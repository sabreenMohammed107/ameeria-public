<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
	use SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name'
    ];

    /**
     * The attributes that should be handling in the activityLog.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    protected static $logName = 'City';
    
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have been {$eventName} City";
    }
}
