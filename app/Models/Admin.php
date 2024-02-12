<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "user_id";

    // admin is a user
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    // has logs through the parent user
    public function activity_logs(): HasManyThrough{
        return $this->hasManyThrough(ActivityLog::class, User::class, localKey: "user_id");
    }
}
