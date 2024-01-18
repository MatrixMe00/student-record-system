<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SchoolAdmin extends Admin
{
    use HasFactory;

    // has many results via school
    public function approvedResults(): HasManyThrough{
        return $this->hasManyThrough(ApproveResults::class, School::class);
    }

    // admin has a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }
}
