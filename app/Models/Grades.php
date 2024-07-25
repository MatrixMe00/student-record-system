<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Grades extends Model
{
    use HasFactory;

    protected $guarded = [];

    // many grades to one student
    public function student(): BelongsTo{
        return $this->belongsTo(Student::class, "student_id");
    }

    // many grades belong to one teacher
    public function teacher(): BelongsTo{
        return $this->belongsTo(Teacher::class);
    }

    // many grades are in one school
    public function school(): HasOne{
        return $this->hasOne(School::class);
    }

    // grades belong to a program
    public function program(): BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // grade has a subject attached to it
    public function subject(): HasOne{
        return $this->hasOne(Subject::class, "id", "subject_id");
    }

    // a grade belongs to a result set
    public function result(): HasOne{
        return $this->hasOne(ApproveResults::class, "result_token", "result_token");
    }

    // sums the class mark and exam mark
    public function getTotalAttribute() :int{
        return $this->class_mark + $this->exam_mark;
    }

    /**
     * Gets the total number of students for a specified program
     */
    public function student_count() :int{
        $count = 0;
        if($this->student_id > 0){
            $result_token = Grades::where("student_id", $this->student_id)
                              ->where('program_id', $this->program_id)
                              ->where('semester', $this->semester)
                              ->take(1)->first()?->result_token;
            $count = Grades::where("result_token", $result_token)->get()->count();
        }

        return $count;
    }

    /**
     * Basically for the student. It returns all results for a specified program
     */
    public function my_results() :Collection{
        return Grades::where("student_id", $this->student_id)
                     ->where("program_id", $this->program_id)
                     ->where("semester", $this->semester)
                     ->where("status", "accepted")
                     ->get();
    }

    /**
     * Used by the remarks section to retrieve data for a specific class
     */
    public function class_results(){
        $results = Grades::where("semester", $this->semester)
                         ->where("program_id", $this->program_id)
                         ->where("academic_year", $this->academic_year)
                         ->get();
        $results = $results->groupBy("student_id");
        $totals = $results->map(function($result){
            $class_total = $result->sum("class_mark");
            $exam_total = $result->sum("exam_mark");

            if($result->first()->student){
                return [
                    "student" => $result->first()->student,
                    "class_total" => $class_total,
                    "exam_total" => $exam_total,
                    "total" => intval($exam_total + $class_total)
                ];
            }
        });

        return $totals->sortByDesc("total");
    }
}
