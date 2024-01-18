<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveResults extends Model
{
    use HasFactory;

    protected $guarded = [];

    // a result has many grades
    public function grades(){
        return $this->hasMany(Grades::class, "result_token", "result_token");
    }

    // every result has a teacher
    public function teacher(){
        return $this->hasOne(Teacher::class);
    }

    // every result belongs to a program
    public function program(){
        return $this->belongsTo(Program::class);
    }
}
