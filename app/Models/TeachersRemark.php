<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TeachersRemark extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        // based on the user role
        $school_id = session('school_id') ?? null;

        if($school_id){
            $query->where(self::getTable().'.school_id', $school_id);
        }

        return $query;
    }

    // belongs to a teacher
    public function teacher() :HasOne{
        return $this->hasOne(Teacher::class, "user_id", "teacher_id");
    }

    // belongs to a program
    public function program() :BelongsTo{
        return $this->belongsTo(Program::class);
    }

    // has many remarks
    public function remarks() :HasMany{
        return $this->hasMany(TeacherRemarks::class, "remark_token", "remark_token");
    }

    // promoted class
    public function promoted_class() :BelongsTo{
        return $this->belongsTo(Program::class, "promotion_class");
    }
}
