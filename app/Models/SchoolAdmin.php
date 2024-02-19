<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SchoolAdmin extends Admin
{
    protected $table = "admins";

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user role
        if(auth()->user()->role_id < 3){
            $query->where('school_id', '>', 0);
        }else{
            $query->where('school_id', $this->school_id);
        }

        return $query;
    }

    // has many results via school
    public function approvedResults(): HasManyThrough{
        return $this->hasManyThrough(ApproveResults::class, School::class);
    }

    // admin has a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }
}
