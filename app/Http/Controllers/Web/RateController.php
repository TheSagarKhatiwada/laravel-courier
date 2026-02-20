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
        return view('welcome', compact('rates'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'    => 'required|exists:branches,id',
            'service_type' => 'required|in:standard,express,same_day',
            'base_weight'  => 'required|numeric|min:0',
            'base_price'   => 'required|numeric|min:0',
        ]);
        $rate = CourierRate::create($validated);
        return redirect()->route('rates.show', $rate)->with('success', 'Rate created.');
    }

    public function show(CourierRate $rate)
    {
        return view('welcome', compact('rate'));
    }

    public function edit(CourierRate $rate)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('rate', 'branches'));
    }

    public function update(Request $request, CourierRate $rate)
    {
        $validated = $request->validate([
            'base_price' => 'sometimes|numeric|min:0',
        ]);
        $rate->update($validated);
        return redirect()->route('rates.show', $rate)->with('success', 'Rate updated.');
    }

    public function destroy(CourierRate $rate)
    {
        $rate->update(['is_active' => false]);
        return redirect()->route('rates.index')->with('success', 'Rate deactivated.');
    }
}
