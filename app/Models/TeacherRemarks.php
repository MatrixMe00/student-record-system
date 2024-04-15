<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TeacherRemarks extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user role
        $school_id = session('school_id') ?? null;

        if($school_id){
            $query->where(self::getTable().'.school_id', $school_id);
        }

        return $query;
    }

    // belongs to a teacher
    public function teacher() :BelongsTo{
        return $this->belongsTo(Teacher::class);
    }

    // belongs to a student
    public function student() :BelongsTo{
        return $this->belongsTo(Student::class, "student_id");
    }

    // belongs to a program
    public function program() :BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // belongs to a school
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    // this will be used to get the head remark
    public function head_remark() :BelongsTo{
        return $this->belongsTo(TeachersRemark::class, "remark_token", "remark_token");
    }
}
