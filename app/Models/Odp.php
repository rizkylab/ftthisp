<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    protected $fillable = [
        'name',
        'coordinates',
        'capacity',
        'used_core',
        'olt_id',
        'status',
        'notes'
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public function olt()
    {
        return $this->belongsTo(Olt::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
