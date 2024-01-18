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

    // a result has many grades
    public function grades(): HasMany{
        return $this->hasMany(Grades::class, "result_token", "result_token");
    }

    // every result has a teacher
    public function teacher(): HasOne{
        return $this->hasOne(Teacher::class);
    }

    // every result belongs to a program
    public function program(): BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // every result belongs to a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }
}
