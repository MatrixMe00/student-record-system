<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "user_id";

    // perform some delete functionalities
    protected static function boot() {
        parent::boot();

        static::deleting(function($student){
            if($student->user){
                $student->user->delete();
            }
        });
    }

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $table = self::getTable();

        // based on the user role
        $school_id = session('school_id') ?? null;
        if($school_id){
            $query->where($table.'.school_id', $school_id);
        }

        $query->where("$table.is_deleted", false);

        return $query;
    }

    // student grades
    public function results(): HasManyThrough{
        return $this->hasManyThrough(ApproveResults::class, Grades::class, "student_id", "result_token", null, "result_token");
    }

    // student belongs to a program
    public function program(): BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // student belongs to a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }

    // has logs through the parent user
    public function activity_logs(): HasManyThrough{
        return $this->hasManyThrough(ActivityLog::class, User::class, localKey: "user_id");
    }

    // belongs to the user class
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    // calculate the grades
    public function average_grade(){
        $class = Grades::where("student_id", $this->user_id)->where('status','accepted')->avg("class_mark");
        $exam = Grades::where("student_id", $this->user_id)->where('status','accepted')->avg("exam_mark");

        return $class + $exam;
    }

    // grade value
    public function grade_value($value = null) :int{
        $value = is_null($value) ? $this->average_grade() : $value;
        $breakpoints = [
            ["max" => 24, "grade" => 9],
            ["max" => 34, "grade" => 8],
            ["max" => 39, "grade" => 7],
            ["max" => 44, "grade" => 6],
            ["max" => 49, "grade" => 5],
            ["max" => 59, "grade" => 4],
            ["max" => 69, "grade" => 3],
            ["max" => 79, "grade" => 2],
            ["max" => 100, "grade" => 1]
        ];

        foreach($breakpoints as $breakpoint){
            if($value <=  $breakpoint["max"]){
                return $breakpoint["grade"];
            }
        }
    }

    /**
     * Create a fullname attribute
     */
    public function getFullnameAttribute(){
        return $this->lname." ".$this->oname;
    }

    // grade description
    public function grade_description(?int $grade_value = null) :string{
        $grade_value = is_null($grade_value) ? $this->grade_value() : $grade_value;
        $grade_value = $grade_value < 1 ? 9 : $grade_value;
        $descriptions = [
            "Excellent", "Very Good", "Good", "Credit",
            "Credit", "Credit", "Pass", "Pass", "Fail"
        ];

        return $descriptions[$grade_value - 1];
    }
}
