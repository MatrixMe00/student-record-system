<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Crypt;

class School extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * creates an encrypted version of the id
     * @return string|null
     */
    public function getProtectedIdAttribute(){
        if($this->id == null){
            return null;
        }

        return Crypt::encryptString($this->id);
    }

    // students
    public function students() :HasMany{
        return $this->hasMany(Student::class);
    }

    // schools have programs
    public function programs() :HasMany{
        return $this->hasMany(Program::class);
    }

    // schools have teachers
    public function teachers() :HasMany{
        return $this->hasMany(Teacher::class);
    }

    // schools have admins
    public function school_admins() :HasMany{
        return $this->hasMany(SchoolAdmin::class);
    }

    // school custom admins
    public function custom_admins() :HasMany{
        return $this->hasMany(other::class);
    }

    // every school has one setting
    public function settings() :HasOne{
        return $this->hasOne(SchoolSetting::class);
    }

    // school has a list of subjects
    public function subjects() :HasMany{
        return $this->hasMany(Subject::class);
    }

    // school admin
    public function admin() :HasOne{
        return $this->hasOne(SchoolAdmin::class, "user_id", "admin_id");
    }
}
