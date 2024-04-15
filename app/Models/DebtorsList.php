<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebtorsList extends Model
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

    // owed by a student
    public function student() :BelongsTo{
        return $this->belongsTo(Student::class, "student_id");
    }
}
