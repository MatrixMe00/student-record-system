<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user role
        if(auth()->user()->role_id >= 3){
            $query->where('school_id', $this->school_id);
        }

        return $query;
    }

    // subject belongs to a school
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    // classes learning this subject
    public function programs() :HasManyThrough{
        return $this->hasManyThrough(Program::class, TeacherClass::class);
    }

    // teacher for this subject
    public function teacher() :HasOneThrough{
        return $this->hasOneThrough(Teacher::class, TeacherClass::class);
    }
}
