<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setNameAttribute($value){
        $this->attributes["name"] = strtolower($value);
    }

    /**
     * Accessor for input_type (maps to type column for backward compatibility)
     */
    public function getInputTypeAttribute()
    {
        return $this->attributes['type'] ?? null;
    }

    /**
     * Mutator for input_type (maps to type column)
     */
    public function setInputTypeAttribute($value)
    {
        $this->attributes['type'] = $value;
    }
}
