<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
class Client extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'general_account',
        'help_account',
        'name',
        'commercial_register',
        'tax_card_id',
        'city_id',
        'address',
        'phone',
        'email',
        'notes',
    ];

    /**
     * The attributes that should be handling in the activityLog.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    protected static $logName = 'Setting';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have been {$eventName} Setting";
    }
}
