<?php

namespace App\Http\Controllers;

use App\Models\StudentBill;
use App\Http\Requests\StoreStudentBillRequest;
use App\Http\Requests\UpdateStudentBillRequest;
use App\Models\Program;
use App\Traits\ProgramModelTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class StudentBillController extends Controller
{
    use ProgramModelTrait;
    /**
     * Display a listing of the resource.
     */
    public function index($academic_year = null)
    {
        if($jhs3 = $this->jhs3()){
            $programs = Program::where("id", "!=", $jhs3->id)->get();
        }else{
            $programs = Program::all();
        }

        $academic_year = $academic_year ?? get_academic_year(now());

        // get the academic years
        $academic_years = $this->get_academic_years();

        return view("student_bills.index",[
            "programs" => $programs,
            "current_year" => format_academic_year($academic_year, false),
            "academic_years" => $academic_years
        ]);

    }

    /**
     * Gets the individual academic years
     */
    private function get_academic_years(){
        $bills = StudentBill::distinct()->pluck("academic_year");

        if($bills->count() > 0){
            $bills = $bills->groupBy("academic_year")->map(function($billGroup){
                return $billGroup->first();
            });
        }else{
            $bills = new Collection([get_academic_year(now())]);
        }

        return $bills;
    }

    /**
     * This gets the id of the JHS3 classrooms
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentBillRequest $request, $academic_year, Program $program)
    {
        if(is_null($request->id)){
            throw ValidationException::withMessages([
                "custom_error" => "No data has been filed for processing"
            ]);
        }

        $validated = $request->validated();
        $validated["academic_year"] = year_link($academic_year, false);
        $validated["id"] = $request->id;

        foreach($validated["id"] as $count => $id){
            if($id > 0){
                $bill = StudentBill::find($id);
                $bill->update([
                    "amount" => $validated["amount"][$count]
                ]);
            }else{
                if($this->bill_exists($validated["student_id"][$count], $validated["program_id"])){
                    throw ValidationException::withMessages([
                        "custom_error" => "Records for ".$request->fullname[$count]." already exists"
                    ]);
                }
                StudentBill::create([
                    "student_id" => $validated["student_id"][$count],
                    "school_id" => $validated["school_id"],
                    "program_id" => $validated["program_id"],
                    "amount" => $validated["amount"][$count],
                    "academic_year" => $validated["academic_year"]
                ]);
            }
        }

        return redirect()->back()->with(["success" => true, "message" => "List has been updated"]);
    }

    /**
     * Checks if billing data already exists
     * @param int $student_id The id of the student
     * @param int $program_id The id of the program
     * @return bool
     */
    private function bill_exists(int $student_id, int $program_id) :bool{
        return StudentBill::where("student_id", $student_id)
                          ->where("program_id", $program_id)
                          ->exists();
    }

    /**
     * Display the specified resource.
     */
    public function show($academic_year, Program $program)
    {
        $academic_year = year_link($academic_year, false);
        $students = StudentBill::where("academic_year", $academic_year)
                               ->where("program_id", $program->id)
                               ->where("status", false)
                               ->get();

        return view("student_bills.show", [
            "program" => $program,
            "academic_year" => $academic_year,
            "students" => $students,
            "total_amount" => 0
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($academic_year, Program $program)
    {
        $academic_year = year_link($academic_year, false);
        $students = StudentBill::where("academic_year", $academic_year)
                               ->where("program_id", $program->id)
                               ->where("status", true)
                               ->get();

        return view("student_bills.edit", [
            "program" => $program,
            "academic_year" => $academic_year,
            "students" => $students,
            "class_students" => $program->students,
            "school_id" => session('school_id') ??  $program->school->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentBillRequest $request, StudentBill $studentBill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentBill $studentBill)
    {
        return $studentBill->delete();
    }
}
