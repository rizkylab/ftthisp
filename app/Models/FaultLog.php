<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaultLog extends Model
{
    protected $fillable = [
        'technician_id',
        'location',
        'cause',
        'photo_path',
        'status'
    ];

    protected $casts = [
        'location' => 'array',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
