<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentBill extends Model
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

    /**
     * The student of this bill
     */
    public function student() :BelongsTo{
        return $this->belongsTo(Student::class, "student_id");
    }

    /**
     * This belongs to a school
     */
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    /**
     * Has a program
     */
    public function program() :HasOne{
        return $this->hasOne(Program::class);
    }
}
