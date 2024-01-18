<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    // teacher
    public function teacher() :BelongsTo{
        return $this->belongsTo(Teacher::class, "teacher_id", "user_id");
    }
}
