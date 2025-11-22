<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiberCable extends Model
{
    protected $fillable = [
        'name',
        'core_count',
        'color',
        'coordinates',
        'status',
        'length_meters',
        'total_loss_db'
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public function splices()
    {
        return $this->hasMany(Splice::class);
    }

    public function connectors()
    {
        return $this->hasMany(Connector::class);
    }

    public function calculateLoss($attenuationRate = 0.3) // dB/km usually around 0.2-0.3 for 1310nm/1550nm
    {
        $lengthKm = $this->length_meters / 1000;
        $spliceLoss = $this->splices()->sum('loss_value');
        $connectorLoss = $this->connectors()->sum('loss_value');
        
        $totalLoss = ($lengthKm * $attenuationRate) + $spliceLoss + $connectorLoss;
        
        $this->update(['total_loss_db' => $totalLoss]);
        
        return $totalLoss;
    }
}
