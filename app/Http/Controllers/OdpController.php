<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use App\Models\Olt;
use Illuminate\Http\Request;

class OdpController extends Controller
{
    public function index()
    {
        $odps = Odp::with('olt')->latest()->paginate(10);
        return view('odps.index', compact('odps'));
    }

    public function create()
    {
        $olts = Olt::all();
        return view('odps.create', compact('olts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coordinates' => 'required|json',
            'capacity' => 'required|integer|min:1',
            'olt_id' => 'required|exists:olts,id',
            'status' => 'required|in:active,maintenance,down',
            'notes' => 'nullable|string',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        Odp::create($validated);

        return redirect()->route('odps.index')->with('success', 'ODP created successfully.');
    }

    public function show(Odp $odp)
    {
        return view('odps.show', compact('odp'));
    }

    public function edit(Odp $odp)
    {
        $olts = Olt::all();
        return view('odps.edit', compact('odp', 'olts'));
    }

    public function update(Request $request, Odp $odp)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coordinates' => 'required|json',
            'capacity' => 'required|integer|min:1',
            'olt_id' => 'required|exists:olts,id',
            'status' => 'required|in:active,maintenance,down',
            'notes' => 'nullable|string',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        $odp->update($validated);

        return redirect()->route('odps.index')->with('success', 'ODP updated successfully.');
    }

    public function destroy(Odp $odp)
    {
        $odp->delete();
        return redirect()->route('odps.index')->with('success', 'ODP deleted successfully.');
    }
}
