<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class deletedusers extends Model
{
    use HasFactory;

    protected $guarded = [];

    // the role of the user
    public function role(): HasOne{
        return $this->hasOne(Role::class);
    }

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

    // belongs to a school
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    // is a user
    public function user() :HasOne{
        return $this->hasOne(User::class, "id", "user_id");
    }
}
