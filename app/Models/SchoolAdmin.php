<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAdmin extends Admin
{
    use HasFactory;

    // approve results
    public function approvedResults(){
        return $this->hasMany(approveresults::class);
    }

    // admin has a school
    public function school(){
        return $this->belongsTo(School::class);
    }
}
