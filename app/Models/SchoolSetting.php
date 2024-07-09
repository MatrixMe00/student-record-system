<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    // has only one school
    public function school(): BelongsTo{
        return $this->belongsTo(School::class);
    }

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $table = self::getTable();

        // based on the user role
        $school_id = session('school_id') ?? null;
        if($school_id){
            $query->where($table.'.school_id', $school_id);
        }

        return $query;
    }
}
