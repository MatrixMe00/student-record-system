<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApproveResults extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "approveresults";

    // edit query depending on some results
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user role
        $school_id = session('school_id') ?? null;
        $program_id = $this->program_id ?? null;
        $teacher_id = $this->teacher_id ?? null;
        if($school_id){
            $query->where(self::getTable().'.school_id', $school_id);
        }
        if($program_id){
            $query->where('program_id', $program_id);
        }
        if($teacher_id){
            $query->where('teacher_id', $teacher_id);
        }

        return $query;
    }

    // a result has many grades
    public function grades(): HasMany{
        return $this->hasMany(Grades::class, "result_token", "result_token");
    }

    // results belong to a subject
    public function subject(): BelongsTo{
        return $this->belongsTo(Subject::class);
    }

    // every result has a teacher
    public function teacher(): HasOne{
        return $this->hasOne(Teacher::class, "user_id", "teacher_id");
    }

    // every result belongs to a program
    public function program(): BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // every result belongs to a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }

    // admin for result approval
    public function admin() :HasOne{
        return $this->hasOne(SchoolAdmin::class, "user_id", "admin_id");
    }
}
