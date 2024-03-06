<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TeacherClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    // subject
    public function subject() :HasOne{
        return $this->hasOne(Subject::class);
    }

    // get program information
    public function program() :BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // can have many programs if a subject is provided
    public function programs() :HasMany|null{
        if($this->subject_id > 0){
            return $this->hasMany(Program::class);
        }

        return null;
    }

    // can have many teachers if a subject is provided
    public function teachers() :HasMany|null{
        if($this->subject_id > 0){
            return $this->hasMany(Teacher::class);
        }

        return null;
    }

    // can have many teachers if a subject is provided
    public function teacher() :HasOne{
        return $this->hasOne(Teacher::class);
    }
}
