<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    use HasFactory;

    protected $guarded = [];

    // many grades to one student
    public function student(){
        return $this->belongsTo(Student::class);
    }

    // many grades belong to one teacher
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    // many grades are in one school
    public function school(){
        return $this->hasOne(School::class);
    }

    // grades belong to a program
    public function program(){
        return $this->belongsTo(Program::class);
    }
}
