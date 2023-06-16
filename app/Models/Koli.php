<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Koli extends Model
{
    use HasFactory;

    protected $collection = 'koli';

    protected $fillable = [
        'koli_length',
        'awb_url',
        'koli_chargeable_weight',
        'koli_width',
        'koli_surcharge',
        'koli_height',
        'koli_description',
        'koli_formula_id',
        'connote_id',
        'koli_volume',
        'koli_weight',
        'koli_id',
        'koli_custom_field',
        'koli_code',
    ];

    protected $casts = [
        'koli_length' => 'integer',
        'koli_chargeable_weight' => 'integer',
        'koli_width' => 'integer',
        'koli_surcharge' => 'array',
        'koli_height' => 'integer',
        'koli_volume' => 'integer',
        'koli_weight' => 'integer',
        'koli_custom_field' => 'array',
    ];

    public function connote()
    {
        return $this->belongsTo(Connote::class, 'connote_id', 'connote_id');
    }
}
