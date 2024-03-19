<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SchoolAdmin extends Model
{
    protected $table = "admins";
    protected $primaryKey = "user_id";

    protected $guarded = [];

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user school
        if($this->school_id !== null || session('school_id')){
            $query->where('school_id', ($this->school_id ?? session('school_id')));
        }else{
            $query->where('school_id', '>', 0);
        }

        return $query;
    }

    // has many results via school
    public function approvedResults(): HasManyThrough{
        return $this->hasManyThrough(ApproveResults::class, School::class);
    }

    // admin has a school
    public function school(): BelongsTo|null{
        return $this->school_id ? $this->belongsTo(School::class) : null;
    }

    // admin is a user
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    // has logs through the parent user
    public function activity_logs(): HasManyThrough{
        return $this->hasManyThrough(ActivityLog::class, User::class, localKey: "user_id");
    }
}
