<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Program extends Model
{
    use HasFactory;

    protected $guarded = [];

    // program belongs to a school
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    // program has many students
    public function students() :HasMany{
        return $this->hasMany(Student::class);
    }

    // teachers teaching the class
    public function teachers() :HasMany{
        return $this->hasMany(TeacherClass::class);
    }

    // teacher teaching the class
    public function teacher() :HasOne{
        return $this->hasOne(Teacher::class, "user_id", "class_teacher");
    }

    // every program has many subjects taught in it
    public function subjects() :HasManyThrough{
        return $this->hasManyThrough(Subject::class, TeacherClass::class);
    }

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user role
        $school_id = auth()->user()?->school->id ?? null;
        if($school_id){
            $query->where('school_id', $school_id);
        }

        return $query;
    }
}
