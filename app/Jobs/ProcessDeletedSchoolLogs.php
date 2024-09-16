<?php

namespace App\Jobs;

use App\Models\ActivityLog;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessDeletedSchoolLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $school_directory;
    protected string $details_path = "details.txt";
    protected string $logs_path = "logs.txt";

    /**
     * Create a new job instance.
     */
    public function __construct(protected School $school)
    {
        $this->create_school_folder();
    }

    /**
     * Creates a folder for the school
     */
    private function create_school_folder(){
        if(!Storage::exists("storage/deleted_schools")){
            Storage::makeDirectory("storage/deleted_schools");
        }

        $this->school_directory = "storage/deleted_schools/". time()."_".$this->school->id;
        Storage::makeDirectory($this->school_directory);
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $details_content = $this->get_school_details();
        $activity_logs = $this->activity_logs();

        Storage::put($this->school_directory."/".$this->details_path, $details_content);
        Storage::put($this->school_directory."/".$this->logs_path, $activity_logs);

        $details_path = $this->school_directory."/".$this->details_path;

        // return response()->download(url(storage_path($details_path)));
        return Storage::download($details_path);
    }

    /**
     * Gets the school details
     */
    private function get_school_details(){
        $details = "
            About
            -----
            School Name: {$this->school->school_name}
            School Slug: {$this->school->slug_name}
            Circuit: {$this->school->circuit}
            GPS Address: {$this->school->gps_address}
            Box Number: {$this->school->box_number}
            District: {$this->school->district}
            School Email: {$this->school->school_email}
            Head Master: {$this->school->school_head}
            School Admin: {$this->school->admin->user->fullname}
            Created At: {$this->school->created_at}

            Metrics
            -------
            Total Admins: ".$this->school->school_admins()->count()."
            Total Students: ".$this->school->students()->count()."
            Total Teachers: ".$this->school->teachers()->count()."
            Total Classes: ".$this->school->programs()->count()."

            ----------\t----------
            This report was generated at ".Carbon::now()->format("d-M-Y H:i:s")." by System
        ";

        return $details;
    }

    /**
     * Get all the activity logs
     */
    private function activity_logs(){
        $activity_logs = ActivityLog::where("school_id", $this->school->id)->orderBy("user_id", "asc")->get();
        $log_string = "";
        $user_p = null;

        foreach($activity_logs as $log){
            $details = $log->log_details;

            if($user_p !== $log->user_id){
                $user = $log->user;
                $user_data = "$user->fullname ($user->username) - ".$user->role->name;

                // the user data should come first
                $log_string .= "\n\n$user_data\n".$this->underline($user_data)."\n";
            }

            // format the log message
            $log_message = fix_message($log->message, ActivityLog::array_to_model($details["original"] ?? $details));
            $log_string .= "$log->created_at : $log_message\n";

            $user_p = $log->user_id;
        }

        return $log_string;
    }

    private function underline(string $text){
        $response = "";

        for($i = 0; $i < strlen($text); $i++){
            $response .= "-";
        }

        return $response;
    }
}
