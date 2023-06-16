<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $collection = 'transactions';

    protected $fillable = [
        'transaction_id',
        'customer_name',
        'customer_code',
        'transaction_amount',
        'transaction_discount',
        'transaction_additional_field',
        'transaction_payment_type',
        'transaction_state',
        'transaction_code',
        'transaction_order',
        'location_id',
        'organization_id',
        'transaction_payment_type_name',
        'transaction_cash_amount',
        'transaction_cash_change',
        'customer_attribute',
        'connote_id',
        'origin_data',
        'destination_data',
        'custom_field',
        'currentLocation',
    ];

    protected $casts = [
        'transaction_order' => 'integer',
        'organization_id' => 'integer',
        'transaction_cash_amount' => 'float',
        'transaction_cash_change' => 'float',
        'customer_attribute' => 'array',
        'origin_data' => 'array',
        'destination_data' => 'array',
        'custom_field' => 'array',
        'currentLocation' => 'array',
    ];

    public function connote()
    {
        return $this->belongsTo(Connote::class, 'connote_id', 'connote_id');
    }

    public function koliData()
    {
        return $this->hasMany(Koli::class, 'connote_id', 'connote_id');
    }
}
