<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UserModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserModelTrait;

    /**
     * @var Model $user_model An instance of the user's sub-model
     */
    public ?Model $user_model = null;

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

    /**
     * sets up the user model
     */
    private function set_user_model(){
        $role_id = $this->role_id ?? $this->attributes["role_id"];
        if($role_id > 0 && $this->user_model == null){
            $this->user_model = $this->user_model($this);
        }
    }

    /**
     * Set the user model attribute in the public scope
     */
    public function setUserModel(){
        $this->set_user_model();
    }

    /**
     * Automatically hash the password when setting it
     */
    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * System user ID - the first user created (developer role)
     * This user should never be deleted as it's used for system logs
     */
    const SYSTEM_USER_ID = 1;

    /**
     * Prevent system user from being deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Prevent system user (ID = 1) from being deleted
            if ($user->id === self::SYSTEM_USER_ID) {
                throw new \Exception('System user cannot be deleted');
            }
        });
    }

    // every user has a role
    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }

    // every user has many activity logs
    public function activityLogs(): HasMany{
        return $this->hasMany(ActivityLog::class);
    }

    // get lastname from here
    public function getLnameAttribute(){
        $this->set_user_model();
        return $this->user_model?->lname;
    }

    // get othernames
    public function getOnameAttribute(){
        $this->set_user_model();
        return $this->user_model?->oname;
    }

    // get fullname
    public function getFullnameAttribute(){
        $this->set_user_model();
        return $this->user_model?->fullname;
    }
}
