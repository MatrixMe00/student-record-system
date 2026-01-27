<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class School extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate school_slug from school_name before creating
        static::creating(function ($school) {
            if (empty($school->school_slug) && !empty($school->school_name)) {
                $school->school_slug = static::generateSlug($school->school_name);
            }
        });

        // Auto-generate school_slug from school_name before updating if name changed
        static::updating(function ($school) {
            if ($school->isDirty('school_name')) {
                $school->school_slug = static::generateSlug($school->school_name, $school->id);
            }
        });

        static::deleting(function($school){
            $students = $school->students()->pluck("user_id");
            $teachers = $school->teachers()->pluck("user_id");
            $admins = $school->school_admins()->pluck("user_id");

            $ids = array_merge($students->toArray(), $teachers->toArray(), $admins->toArray());

            User::whereIn("id", $ids)->delete();
        });
    }

    /**
     * Generate a unique slug from school name
     */
    protected static function generateSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('school_slug', $slug)
            ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

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
    public function settings() :HasMany{
        return $this->hasMany(SchoolSetting::class);
    }

    // school has a list of subjects
    public function subjects() :HasMany{
        return $this->hasMany(Subject::class);
    }

    // school admin
    public function admin() :HasOne{
        return $this->hasOne(SchoolAdmin::class, "user_id", "admin_id");
    }

    // for superadmin usage
    /**
     * Finds the various grades for the school
     */
    public function results() :HasMany{
        return $this->hasMany(ApproveResults::class);
    }

    /**
     * Find various remark details for the school
     */
    public function remarks() :HasMany{
        return $this->hasMany(TeacherRemarks::class);
    }

    /**
     * Gets the payment information for this school
     */
    public function payment_information() :HasMany{
        return $this->hasMany(PaymentInformation::class);
    }
}
