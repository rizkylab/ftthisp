<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Olt extends Model
{
    protected $fillable = [
        'name',
        'type',
        'coordinates',
        'total_ports',
        'used_ports',
        'status'
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public function odps()
    {
        return $this->hasMany(Odp::class);
    }
}
