<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourierRate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index(Request $request)
    {
        $query = CourierRate::with('branch')->where('is_active', true);
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->has('service_type')) {
            $query->where('service_type', $request->service_type);
        }
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'               => 'required|exists:branches,id',
            'service_type'            => 'required|in:standard,express,same_day',
            'origin_zone'             => 'nullable|string',
            'destination_zone'        => 'nullable|string',
            'base_weight'             => 'required|numeric|min:0',
            'base_price'              => 'required|numeric|min:0',
            'additional_weight_price' => 'nullable|numeric|min:0',
            'fuel_surcharge_pct'      => 'nullable|numeric|min:0',
            'cod_charge_pct'          => 'nullable|numeric|min:0',
        ]);

        $rate = CourierRate::create($validated);
        return response()->json($rate, 201);
    }

    public function show(CourierRate $rate)
    {
        return response()->json($rate->load('branch'));
    }

    public function update(Request $request, CourierRate $rate)
    {
        $validated = $request->validate([
            'base_price'              => 'sometimes|numeric|min:0',
            'additional_weight_price' => 'nullable|numeric|min:0',
            'fuel_surcharge_pct'      => 'nullable|numeric|min:0',
            'is_active'               => 'sometimes|boolean',
        ]);

        $rate->update($validated);
        return response()->json($rate);
    }

    public function destroy(CourierRate $rate)
    {
        $rate->update(['is_active' => false]);
        return response()->json(['message' => 'Rate deactivated']);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'branch_id'    => 'required|exists:branches,id',
            'service_type' => 'required|in:standard,express,same_day',
            'weight'       => 'required|numeric|min:0.001',
            'cod_amount'   => 'nullable|numeric|min:0',
        ]);

        $rate = CourierRate::where('branch_id', $request->branch_id)
            ->where('service_type', $request->service_type)
            ->where('is_active', true)
            ->first();

        if (!$rate) {
            return response()->json(['message' => 'No rate found for the given criteria'], 404);
        }

        $weight      = $request->weight;
        $baseCharge  = $rate->base_price;

        if ($weight > $rate->base_weight) {
            $extraWeight = $weight - $rate->base_weight;
            $baseCharge += ceil($extraWeight * 2) * ($rate->additional_weight_price / 2); // per 500g
        }

        $fuelSurcharge = $baseCharge * ($rate->fuel_surcharge_pct / 100);
        $codCharge     = ($request->cod_amount ?? 0) * ($rate->cod_charge_pct / 100);
        $total         = $baseCharge + $fuelSurcharge + $codCharge;

        return response()->json([
            'base_charge'    => round($baseCharge, 2),
            'fuel_surcharge' => round($fuelSurcharge, 2),
            'cod_charge'     => round($codCharge, 2),
            'total'          => round($total, 2),
        ]);
    }
}
