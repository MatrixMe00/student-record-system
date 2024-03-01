<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $school_id = auth()->user()?->school->id ?? null;
        if($school_id){
            $query->where('subjects.school_id', $school_id);
        }

        return $query;
    }

    // subject belongs to a school
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    // classes learning this subject
    public function programs() :HasMany|null{
        $tc = new TeacherClass(["school_id" => $this->school_id, "subject_id" => $this->id]);
        return $tc->programs();
    }

    // teacher for this subject
    public function teachers() :HasMany|null{
        $tc = new TeacherClass(["school_id" => $this->school_id, "subject_id" => $this->id]);
        return $tc->teachers();
    }
}
