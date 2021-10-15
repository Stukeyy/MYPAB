<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'age',
        'gender',
        'location',
        'level',
        'institution',
        'subject',
        'employed',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Hashes user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    { 
        $this->attributes['password'] = Hash::make($value);
    }


    public function getFullNameAttribute() {
        return ucFirst($this->firstname) . " " . ucfirst($this->lastname);
    }

    /**
     * Get the tags that belong to the user.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'user_tags')->withTimestamps();
    }

    /**
     * Get the activities that belong to the user.
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'user_activities')->withTimestamps();
    }

}
