<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BECECandidate extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "bece_candidates";

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

    // associated student
    public function student() :BelongsTo{
        return $this->belongsTo(Student::class, "student_id");
    }

    // school associated
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    // students associated to a school
    public static function students(int $school_id, string $academic_year = "") :Collection{
        $results = static::where("school_id", $school_id);

        if(!empty($academic_year)){
            $results = $results->where("academic_year", format_academic_year($academic_year));
        }

        return $results->get();
    }
}
