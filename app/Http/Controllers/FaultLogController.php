<?php

namespace App\Http\Controllers;

use App\Models\FaultLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FaultLogController extends Controller
{
    public function index()
    {
        $faults = FaultLog::with('technician')->latest()->paginate(10);
        return view('fault_logs.index', compact('faults'));
    }

    public function create()
    {
        return view('fault_logs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|json',
            'cause' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:open,in_progress,resolved',
        ]);

        $data = [
            'technician_id' => Auth::id() ?? 1, // Fallback for dev if not auth
            'location' => json_decode($validated['location'], true),
            'cause' => $validated['cause'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('faults', 'public');
        }

        FaultLog::create($data);

        return redirect()->route('fault_logs.index')->with('success', 'Fault Log created successfully.');
    }

    public function show(FaultLog $faultLog)
    {
        return view('fault_logs.show', compact('faultLog'));
    }

    public function edit(FaultLog $faultLog)
    {
        return view('fault_logs.edit', compact('faultLog'));
    }

    public function update(Request $request, FaultLog $faultLog)
    {
        $validated = $request->validate([
            'location' => 'required|json',
            'cause' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:open,in_progress,resolved',
        ]);

        $data = [
            'location' => json_decode($validated['location'], true),
            'cause' => $validated['cause'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('photo')) {
            if ($faultLog->photo_path) {
                Storage::disk('public')->delete($faultLog->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('faults', 'public');
        }

        $faultLog->update($data);

        return redirect()->route('fault_logs.index')->with('success', 'Fault Log updated successfully.');
    }

    public function destroy(FaultLog $faultLog)
    {
        if ($faultLog->photo_path) {
            Storage::disk('public')->delete($faultLog->photo_path);
        }
        $faultLog->delete();
        return redirect()->route('fault_logs.index')->with('success', 'Fault Log deleted successfully.');
    }
}
