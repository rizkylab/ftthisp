<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FiberCable;
use App\Models\Odp;
use App\Models\Olt;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        return view('map.index');
    }

    public function data()
    {
        return response()->json([
            'olts' => Olt::all(),
            'odps' => Odp::with('olt')->get(),
            'fibers' => FiberCable::all(),
            'customers' => Customer::with('odp')->get(),
        ]);
    }
}
