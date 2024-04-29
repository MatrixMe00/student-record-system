<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "user_id";

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

    // every teacher belongs to a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }

    // every teacher has some results
    public function results(): HasMany{
        return $this->hasMany(ApproveResults::class, "teacher_id");
    }

    // every teacher teaches a set of classes / programs
    public function classes(): HasMany{
        return $this->hasMany(TeacherClass::class, "teacher_id");
    }

    // a teacher can be a class teacher
    public function teacher_class(): HasOne|null{
        return $this->hasOne(Program::class, "class_teacher");
    }

    // has logs through the parent user
    public function activity_logs() :HasManyThrough{
        return $this->hasManyThrough(ActivityLog::class, User::class, localKey: "user_id");
    }

    // teacher teaches many subjects
    public function subjects() :HasManyThrough{
        return $this->hasManyThrough(Subject::class, TeacherClass::class, "teacher_id", "id", secondLocalKey: "subject_id");
    }

    // teacher has many grades
    public function grades() :HasMany{
        return $this->hasMany(Grades::class, "teacher_id");
    }

    // a teacher is a user
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }
}
