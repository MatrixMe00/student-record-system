<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $guarded = [];

    // students
    public function students(){
        return $this->hasMany(Student::class);
    }

    // schools have programs
    public function programs(){
        return $this->hasMany(Program::class);
    }

    // schools have teachers
    public function teachers(){
        return $this->hasMany(Teacher::class);
    }

    // schools have admins
    public function school_admins(){
        return $this->hasMany(SchoolAdmin::class);
    }
}
