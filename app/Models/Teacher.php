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

    // every teacher belongs to a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }

    // every teacher has some results
    public function results(): HasMany{
        return $this->hasMany(ApproveResults::class, "teacher_id", "user_id");
    }

    // every teacher teaches a set of classes / programs
    public function classes(): HasMany{
        return $this->hasMany(TeacherClass::class, "teacher_id", "user_id");
    }

    // a teacher can be a class teacher
    public function teacher_class(): HasOne|false{
        return $this->class_teacher && !is_null($this->program_id) ?
            $this->hasOne(Program::class, "class_teacher", "user_id") : false;
    }

    // has logs through the parent user
    public function activity_logs() :HasManyThrough{
        return $this->hasManyThrough(ActivityLog::class, User::class, localKey: "user_id");
    }

    // teacher teaches many subjects
    public function subjects() :HasManyThrough{
        return $this->hasManyThrough(Subject::class, TeacherClass::class, localKey: "user_id");
    }
}
