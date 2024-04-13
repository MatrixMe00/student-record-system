<?php

namespace App\Http\Controllers;

use App\Models\DebtorsList;
use App\Http\Requests\StoreDebtorsListRequest;
use App\Http\Requests\UpdateDebtorsListRequest;
use App\Models\BECECandidate;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

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
                    "students" => Student::where("program_id", $response["jhs3_id"])->get()
                ];
                break;
            case 5:
                $me = Student::find($user->id);
                $response += [
                    "jhs_valid" => $me->program_id == $response["jhs3_id"],
                    "student" => BECECandidate::where("student_id", $me->user_id)->first()
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
        $data = array_slice($validated, 1);
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
