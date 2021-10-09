<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
class Invoice extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_no',
        'date',
        'client_id',
        'type_id',
        'user_type',
        'person_type',
    'person_name',
    'person_nid',
    'taxable',
        'subtotal',
        'tax',
        'total',
        'status',
        'notes',
    ];
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
    public function item()
    {
        return $this->hasMany('App\Models\InvoiceItem');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\InvoiceType', 'type_id');
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
