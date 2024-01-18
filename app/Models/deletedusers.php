<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class deletedusers extends Model
{
    use HasFactory;

    protected $guarded = [];

    // the role of the user
    public function role(): HasOne{
        return $this->hasOne(Role::class);
    }
}
