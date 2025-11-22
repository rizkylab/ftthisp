<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Odp;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('odp')->latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $odps = Odp::all();
        return view('customers.create', compact('odps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'customer_id_string' => 'required|string|unique:customers,customer_id_string',
            'coordinates' => 'required|json',
            'odp_id' => 'required|exists:odps,id',
            'status' => 'required|in:online,offline,trouble',
            'signal_level_dbm' => 'nullable|numeric',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $odps = Odp::all();
        return view('customers.edit', compact('customer', 'odps'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'customer_id_string' => 'required|string|unique:customers,customer_id_string,' . $customer->id,
            'coordinates' => 'required|json',
            'odp_id' => 'required|exists:odps,id',
            'status' => 'required|in:online,offline,trouble',
            'signal_level_dbm' => 'nullable|numeric',
        ]);

        $validated['coordinates'] = json_decode($validated['coordinates'], true);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
