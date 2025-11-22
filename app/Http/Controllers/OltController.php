<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use Illuminate\Http\Request;

class OltController extends Controller
{
    public function index()
    {
        $olts = Olt::latest()->paginate(10);
        return view('olts.index', compact('olts'));
    }

    public function create()
    {
        return view('olts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'coordinates' => 'required|json', // Expecting JSON string from frontend map picker
            'total_ports' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,down',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        Olt::create($validated);

        return redirect()->route('olts.index')->with('success', 'OLT created successfully.');
    }

    public function show(Olt $olt)
    {
        return view('olts.show', compact('olt'));
    }

    public function edit(Olt $olt)
    {
        return view('olts.edit', compact('olt'));
    }

    public function update(Request $request, Olt $olt)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'coordinates' => 'required|json',
            'total_ports' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,down',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        $olt->update($validated);

        return redirect()->route('olts.index')->with('success', 'OLT updated successfully.');
    }

    public function destroy(Olt $olt)
    {
        $olt->delete();
        return redirect()->route('olts.index')->with('success', 'OLT deleted successfully.');
    }
}
