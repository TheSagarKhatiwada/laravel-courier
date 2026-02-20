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
        return view('welcome', compact('customers'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'code'      => 'required|string|max:20|unique:customers',
            'email'     => 'nullable|email|unique:customers',
            'phone'     => 'nullable|string|max:20',
            'branch_id' => 'nullable|exists:branches,id',
        ]);
        $customer = Customer::create($validated);
        return redirect()->route('customers.show', $customer)->with('success', 'Customer created.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['branch', 'shipments' => fn ($q) => $q->latest()->limit(10)]);
        return view('welcome', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('customer', 'branches'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20',
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
        $ledger = $customer->ledgers()->orderBy('transaction_date', 'desc')->paginate(30);
        return view('welcome', compact('customer', 'ledger'));
    }
}
