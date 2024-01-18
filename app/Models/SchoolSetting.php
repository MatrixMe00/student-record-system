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
}
