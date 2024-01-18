<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

    // every program has many subjects taught in it
    public function subjects() :HasManyThrough{
        return $this->hasManyThrough(Subject::class, TeacherClass::class);
    }
}
