<?php

namespace App\Http\Controllers;

use App\Models\DebtorsList;
use App\Http\Requests\StoreDebtorsListRequest;
use App\Http\Requests\UpdateDebtorsListRequest;
use App\Models\BECECandidate;
use App\Models\BECEResults;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DebtorsListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get options
        $options = $this->index_options();

        return view("bece.index", $options);
    }

    /**
     * The options for the index page
     */
    private function index_options() :array{
        $user = Auth::user();
        $jhs3_id = Program::whereRaw("LOWER(name) = ?", ["jhs 3"])
                          ->orWhereRaw("LOWER(name) = ?", ["jhs3"])->first();
        $response = ["role_id" => $user->role_id, "jhs3_id" => $jhs3_id?->id];

        switch($user->role_id){
            case 3:
                $response += [
                    "candidates" => collection_group(BECECandidate::where("status", true)
                                               ->orderBy("created_at", "desc")
                                               ->get(), "academic_year", ["title", "id"]),
                    "students" => Student::where("program_id", $response["jhs3_id"])
                                         ->where("completed", false)->get(),
                    "debtors" => DebtorsList::where("status", true)->get(),
                    "tags" => [
                        ["id" => "jhs3", "name" => "JHS3 Students"],
                        ["id" => "debt", "name" => "Debtors List"],
                        ["id" => "bece", "name" => "BECE Candidates"]
                    ],
                    "icons" => [
                        "jhs3" => "fas fa-user-graduate", "debt" => "fas fa-file-invoice-dollar", "bece" => "fas fa-graduation-cap"
                    ]
                ];

                $response["current_candidates"] = isset($response["candidates"][0]) ? $response["candidates"][0]["data"]->count() : 0;
                break;
            case 5:
                $me = Student::find($user->id);
                $response += [
                    "jhs_valid" => $me->program_id == $response["jhs3_id"],
                    "student" => BECECandidate::where("student_id", $me->user_id)->first(),
                    "results" => BECEResults::where("student_id", $me->user_id)->get()
                ];
                break;
            default:
                abort(403);
        }

        return $response;
    }

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
    public function store(StoreDebtorsListRequest $request)
    {
        $validated = $request->validated();

        $array = array_slice($validated, 1);
        $pos = -1;
        $total_students = count($validated["id"]);
        $n_stud_count = 0;

        while(++$pos < $total_students){
            if($array["id"][$pos] > 0){
                $data = ["amount" => $array["amount"][$pos]];

                $debtor = DebtorsList::find($array["id"][$pos]);

                if($debtor){
                    $debtor->amount = $array["amount"][$pos];
                    $debtor->update();
                }
            }else{
                DebtorsList::create([
                    "school_id" => $validated["school_id"], "student_id" => $array["student_id"][$n_stud_count++],
                    "amount" => $array["amount"][$pos]
                ]);
            }
        }

        return redirect()->back()->with(["success" => true, "message" => "Debtors list updated", "type" => "debt"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DebtorsList $debtorsList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DebtorsList $debtorsList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebtorsListRequest $request, DebtorsList $debtorsList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DebtorsList $debtorsList)
    {
        //
    }
}
