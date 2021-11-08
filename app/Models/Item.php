<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
class Item extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'code',
        'name',
        'general_account',
        'help_account',
        'exchange_unit_id',
        'storage_unit_id',
        'cost_price',
        'selling_price',
        'request_limit',
        'minimum',
        'maximum',
        'files_count',
        'balance_start_date',
        'balance_start_qty',
        'balance_start_value',
        'balance_qty',
        'balance_value'
    ];

    public function exchange()
    {
        return $this->belongsTo('App\Models\Unit', 'exchange_unit_id');
    }
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
