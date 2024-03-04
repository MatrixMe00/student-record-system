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
    public function program() :HasOne{
        return $this->hasOne(Program::class);
    }

    // can have many teachers if a subject is provided
    public function teacher() :HasOne{
        return $this->hasOne(Teacher::class);
    }
}
