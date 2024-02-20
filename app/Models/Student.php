<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "user_id";

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user role
        if(auth()->user()?->school() || $this->school_id){
            $school_id = auth()->user()->school->id ?? $this->school_id;
            $query->where("school_id", $school_id);
        }

        return $query;
    }

    // student grades
    public function grades(): HasMany{
        return $this->hasMany(Grades::class);
    }

    // student belongs to a program
    public function program(): BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // student belongs to a school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }

    // has logs through the parent user
    public function activity_logs(): HasManyThrough{
        return $this->hasManyThrough(ActivityLog::class, User::class, localKey: "user_id");
    }

    // belongs to the user class
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
