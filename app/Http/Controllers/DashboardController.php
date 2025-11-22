<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FaultLog;
use App\Models\FiberCable;
use App\Models\Odp;
use App\Models\Olt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'olts' => Olt::count(),
            'odps' => Odp::count(),
            'customers' => Customer::count(),
            'faults' => FaultLog::where('status', '!=', 'resolved')->count(),
            'fiber_length' => FiberCable::sum('length_meters'),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
