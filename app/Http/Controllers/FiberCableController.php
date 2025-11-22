<?php

namespace App\Http\Controllers;

use App\Models\FiberCable;
use Illuminate\Http\Request;

class FiberCableController extends Controller
{
    public function index()
    {
        $cables = FiberCable::latest()->paginate(10);
        return view('fiber_cables.index', compact('cables'));
    }

    public function create()
    {
        return view('fiber_cables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'core_count' => 'required|integer|in:4,8,12,24',
            'color' => 'required|string|max:7',
            'coordinates' => 'required|json', // Array of lat/lng
            'status' => 'required|in:normal,degraded,cut',
            'length_meters' => 'required|numeric|min:0',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        $cable = FiberCable::create($validated);
        $cable->calculateLoss();

        return redirect()->route('fiber_cables.index')->with('success', 'Fiber Cable created successfully.');
    }

    public function show(FiberCable $fiberCable)
    {
        return view('fiber_cables.show', compact('fiberCable'));
    }

    public function edit(FiberCable $fiberCable)
    {
        return view('fiber_cables.edit', compact('fiberCable'));
    }

    public function update(Request $request, FiberCable $fiberCable)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'core_count' => 'required|integer|in:4,8,12,24',
            'color' => 'required|string|max:7',
            'coordinates' => 'required|json',
            'status' => 'required|in:normal,degraded,cut',
            'length_meters' => 'required|numeric|min:0',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        $fiberCable->update($validated);
        $fiberCable->calculateLoss();

        return redirect()->route('fiber_cables.index')->with('success', 'Fiber Cable updated successfully.');
    }

    public function destroy(FiberCable $fiberCable)
    {
        $fiberCable->delete();
        return redirect()->route('fiber_cables.index')->with('success', 'Fiber Cable deleted successfully.');
    }
}
