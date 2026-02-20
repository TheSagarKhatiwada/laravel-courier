<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('branch')->latest()->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.customers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:customers',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'pincode' => 'nullable|string|max:20',
            'branch_id' => 'nullable|exists:branches,id',
            'credit_limit' => 'nullable|numeric|min:0',
            'gstin' => 'nullable|string|max:20',
        ]);

        $customer = Customer::create($validated);
        return redirect()->route('customers.show', $customer)->with('success', 'Customer created.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['branch', 'shipments' => fn($q) => $q->latest()->limit(10)]);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.customers.edit', compact('customer', 'branches'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $customer->update($validated);
        return redirect()->route('customers.show', $customer)->with('success', 'Customer updated.');
    }

    public function destroy(Customer $customer)
    {
        $customer->update(['is_active' => false]);
        return redirect()->route('customers.index')->with('success', 'Customer deactivated.');
    }

    public function ledger(Customer $customer)
    {
        $entries = $customer->ledgers()->orderBy('transaction_date', 'desc')->paginate(30);
        return view('admin.customers.ledger', compact('customer', 'entries'));
    }
}
