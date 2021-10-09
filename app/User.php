<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name',
    'l_name',
    'email',
    'username',
    'password',
    'phone',
    'status',
    'avatar',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Roles(){
        return $this->belongsToMany('Role','assigned_roles');
    }
    /**
     * The attributes that should be handling in the activityLog.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    protected static $logName = 'User';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have been {$eventName} User";
    }

}
