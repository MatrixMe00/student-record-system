<?php

namespace App\Models;

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
        return $this->belongsTo(Student::class);
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

    // a grade belongs to a result set
    public function result(): HasOne{
        return $this->hasOne(ApproveResults::class, "result_token", "result_token");
    }
}
