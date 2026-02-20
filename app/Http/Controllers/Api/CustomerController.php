<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('branch')->latest();
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        return response()->json($query->paginate(20));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => 'required|string|max:20|unique:customers',
            'email'        => 'nullable|email|unique:customers',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string',
            'city'         => 'nullable|string',
            'state'        => 'nullable|string',
            'pincode'      => 'nullable|string|max:20',
            'branch_id'    => 'nullable|exists:branches,id',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $customer = Customer::create($validated);
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer->load(['branch', 'shipments' => function ($q) {
            $q->latest()->limit(10);
        }]));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'email'        => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone'        => 'nullable|string|max:20',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active'    => 'sometimes|boolean',
        ]);

        $customer->update($validated);
        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->update(['is_active' => false]);
        return response()->json(['message' => 'Customer deactivated']);
    }

    public function ledger(Customer $customer)
    {
        $ledger = $customer->ledgers()->orderBy('transaction_date', 'desc')->paginate(30);
        return response()->json([
            'customer' => $customer,
            'balance'  => $customer->balance,
            'ledger'   => $ledger,
        ]);
    }

    public function addLedgerEntry(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'type'             => 'required|in:debit,credit',
            'amount'           => 'required|numeric|min:0.01',
            'reference'        => 'nullable|string',
            'remarks'          => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $newBalance = $validated['type'] === 'credit'
            ? $customer->balance + $validated['amount']
            : $customer->balance - $validated['amount'];

        $entry = $customer->ledgers()->create([
            ...$validated,
            'balance' => $newBalance,
        ]);

        $customer->update(['balance' => $newBalance]);

        return response()->json($entry, 201);
    }
}
