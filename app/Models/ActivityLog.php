<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = "activitylogs";

    protected $guarded = [];

    // many activity logs belong to one user
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }
}
