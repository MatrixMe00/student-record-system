<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    // every teacher belongs to a school
    public function school(){
        return $this->belongsTo(School::class);
    }

    // every teacher has some results
    public function results(){
        return $this->hasMany(ApproveResults::class);
    }
}
