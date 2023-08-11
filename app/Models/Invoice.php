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
    protected $cascadeDeletes = ['items'];
    protected $fillable = [
        'invoice_no',
        'e_invoice_type',
        'date',
        'relay_date',
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
        'invoice_document_id',
        'invoice_long_id',
        'invoice_submission_id',
        'inv_id',
        'created_at'
    ];
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
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
