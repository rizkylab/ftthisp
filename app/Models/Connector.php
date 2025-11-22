<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connector extends Model
{
    protected $fillable = [
        'fiber_cable_id',
        'location',
        'loss_value'
    ];

    protected $casts = [
        'location' => 'array',
    ];

    public function fiberCable()
    {
        return $this->belongsTo(FiberCable::class);
    }
}
