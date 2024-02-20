<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    // every user has a role
    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }

    // every user has many activity logs
    public function activityLogs(): HasMany{
        return $this->hasMany(ActivityLog::class);
    }

    // some users belong to schools
    public function school() :BelongsTo|null{
        if($this->role_id >= 3){
            switch($this->role_id){
                case 3:
                    $school_admin = SchoolAdmin::find($this->id);
                    return $school_admin->school();
                case 4:
                    $teacher = Teacher::find($this->id);
                    return $teacher->school();
                case 5:
                    $student = Student::find($this->id);
                    return $student->school();
                default:
                    $other = other::find($this->id);
                    return $other->school();
            }
        }

        return null;
    }
}
