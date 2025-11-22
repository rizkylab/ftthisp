<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'customer_id_string',
        'coordinates',
        'odp_id',
        'status',
        'signal_level_dbm'
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public function odp()
    {
        return $this->belongsTo(Odp::class);
    }
}
