<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    // student grades
    public function grades(){
        return $this->hasMany(Grades::class);
    }

    // student belongs to a program
    public function program(){
        return $this->belongsTo(Program::class);
    }

    // student belongs to a school
    public function school(){
        return $this->belongsTo(School::class);
    }
}
