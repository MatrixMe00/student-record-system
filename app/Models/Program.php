<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $guarded = [];

    // program belongs to a school
    public function school(){
        return $this->belongsTo(School::class);
    }

    // program has many students
    public function students(){
        return $this->hasMany(Student::class);
    }
}
