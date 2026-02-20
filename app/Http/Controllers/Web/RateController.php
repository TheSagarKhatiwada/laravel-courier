<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CourierRate;
use App\Models\Branch;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index()
    {
        $rates = CourierRate::with('branch')->latest()->paginate(20);
        return view('admin.rates.index', compact('rates'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.rates.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'service_type' => 'required|in:standard,express,same_day',
            'origin_zone' => 'nullable|string',
            'destination_zone' => 'nullable|string',
            'base_weight' => 'required|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
            'additional_weight_price' => 'nullable|numeric|min:0',
            'fuel_surcharge_pct' => 'nullable|numeric|min:0',
            'cod_charge_pct' => 'nullable|numeric|min:0',
        ]);

        $rate = CourierRate::create($validated);
        return redirect()->route('rates.index')->with('success', 'Rate created.');
    }

    public function show(CourierRate $rate)
    {
        return view('admin.rates.show', compact('rate'));
    }

    public function edit(CourierRate $rate)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.rates.edit', compact('rate', 'branches'));
    }

    public function update(Request $request, CourierRate $rate)
    {
        $validated = $request->validate([
            'base_price' => 'required|numeric|min:0',
            'additional_weight_price' => 'nullable|numeric|min:0',
            'fuel_surcharge_pct' => 'nullable|numeric|min:0',
            'cod_charge_pct' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $rate->update($validated);
        return redirect()->route('rates.index')->with('success', 'Rate updated.');
    }

    public function destroy(CourierRate $rate)
    {
        $rate->delete();
        return redirect()->route('rates.index')->with('success', 'Rate deleted.');
    }
}
