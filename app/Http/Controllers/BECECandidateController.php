<?php

namespace App\Http\Controllers;

use App\Models\BECECandidate;
use App\Http\Requests\StoreBECECandidateRequest;
use App\Http\Requests\UpdateBECECandidateRequest;
use App\Models\Program;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class BECECandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($school_id)
    {
        $school = School::findOrFail(Crypt::decryptString($school_id));

        if(!$school){
            abort(404);
        }

        // operations
        $candidates = collection_group(BECECandidate::students($school->id), "academic_year");
        $tags = array_keys($candidates->toArray());

        return view("superadmin.candidates.index", [
            "school" => $school,
            "protected_id" => $school_id,
            "tags" => $tags,
            "candidate_data" => $candidates
        ]);
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
    public function store(StoreBECECandidateRequest $request)
    {
        // store default properties for user if its a new data
        if($request->is_new){
            $request->merge([
                "student_token" => create_id(),
                "academic_year" => format_academic_year(get_academic_year(date("d-m-Y")))
            ]);
        }

        // validate the request
        $validated = $request->validate($request->rules());

        // create a new candidate instance
        $candidate = new BECECandidate($validated);

        // create or update the candidate details
        return $candidate->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(BECECandidate $beceCandidate)
    {
        if(!$beceCandidate){
            abort(404, "Candidate was not found");
        }

        return view("superadmin.candidates.show", [
            "candidate" => $beceCandidate,
            "student" => $beceCandidate->student,
            "super_edit" => Auth::user()->role_id < 3,
            "admin_edit" => Auth::user()->role_id == 3
        ]);
    }

    /**
     * Gets all JHS 3 candidates
     */
    private function get_candidates(){
        $program_id = Program::whereRaw("LOWER(name) = ?", ["jhs 3"])
                              ->orWhereRaw("LOWER(name) = ?", ["jhs3"])->first();

        if($program_id){
            $program_id = $program_id->id;
            return Student::leftJoin("bece_candidates", "students.user_id", "=", "bece_candidates.student_id")
                          ->where("students.program_id", $program_id)
                          ->whereNull("bece_candidates.student_id")
                          ->select("students.*")
                          ->get();
        }

        return null;
    }

    public function update_candidates(Request $request){
        foreach($request->id as $key => $id){
            $n_request = new UpdateBECECandidateRequest(request:[
                "id" => $id,
                "student_id" => $request->student_id[$key],
                "index_number" => $request->index_number[$key] ?? null,
                "placement" => $request->placement[$key] ?? null
            ]);

            $candidate = BECECandidate::find($id);

            $this->update($n_request, $candidate);
        }
    }

    /**
     * store details of candidates
     */
    public function create_candidates(){
        $candidates = $this->get_candidates();

        if($candidates?->count() > 0){
            foreach($candidates as $candidate){
                $request = new StoreBECECandidateRequest();
                $request->merge([
                    "student_id" => $candidate->user_id,
                    "school_id" => session('school_id'),
                    "is_new" => true
                ]);

                // store user data
                $this->store($request);
            }

            return redirect()->back()->with(["success" => true, "message" => "{$candidates->count()} candidates created", "type" => "bece"]);
        }else{
            $message = is_null($candidates) ? "JHS 3 Class not found" : "No new JHS3 students were found";
            return redirect()->back()->with(["success" => false, "message" => $message, "type" => "bece"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BECECandidate $bECECandidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBECECandidateRequest $request, BECECandidate $beceCandidate)
    {
        $role_id = Auth::user()->role_id;
        $validated = $request->validated();

        if($role_id < 3){
            $validated["bece_result"] = $this->save_result_file();
            $beceCandidate->update([
                "index_number" => $validated["index_number"],
                "placement" => [
                    "bece_result" => $validated["bece_result"],
                    "placement_school" => $validated["placement_school"]
                ]
            ]);
        }else{
            $beceCandidate->update([
                "index_number" => $validated["index_number"]
            ]);
        }

        return redirect()->back()->with(["status" => true, "message" => "Candidate data has been updated successfully"]);
    }

    private function save_result_file(){
        if(request()->file("bece_result")){
            return request()->file("bece_result")->store("results", "public");
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BECECandidate $bECECandidate)
    {
        //
    }
}
