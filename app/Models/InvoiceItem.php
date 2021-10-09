<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
class InvoiceItem extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'item_id',
        'exchange_unit_id',
        'quantity',
        'price',
        'total',
        'op_permission_no',
        'note',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
    /**
     * The attributes that should be handling in the activityLog.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    protected static $logName = 'InvoiceItem';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have been {$eventName} InvoiceItem";
    }
}
