<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function publicTrack(string $awb)
    {
        $shipment = Shipment::with(['trackings' => function ($q) {
            $q->orderBy('tracked_at', 'desc');
        }, 'branch'])
            ->where('awb_number', $awb)
            ->first();

        if (!$shipment) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        return response()->json([
            'awb_number'            => $shipment->awb_number,
            'status'                => $shipment->status,
            'sender_city'           => $shipment->sender_city,
            'receiver_city'         => $shipment->receiver_city,
            'booking_date'          => $shipment->booking_date,
            'expected_delivery_date'=> $shipment->expected_delivery_date,
            'delivered_at'          => $shipment->delivered_at,
            'trackings'             => $shipment->trackings,
        ]);
    }

    public function bulkTrack(Request $request)
    {
        $request->validate([
            'awb_numbers' => 'required|array|max:50',
        ]);

        $shipments = Shipment::with(['trackings' => function ($q) {
            $q->orderBy('tracked_at', 'desc')->limit(1);
        }])
            ->whereIn('awb_number', $request->awb_numbers)
            ->get(['id', 'awb_number', 'status', 'sender_city', 'receiver_city', 'booking_date', 'delivered_at']);

        return response()->json($shipments);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'status'     => 'required|in:booked,picked,in_transit,out_for_delivery,delivered,returned,cancelled',
            'location'   => 'nullable|string|max:255',
            'remarks'    => 'nullable|string',
            'tracked_at' => 'nullable|date',
        ]);

        $shipment->update(['status' => $validated['status']]);

        if ($validated['status'] === 'delivered') {
            $shipment->update(['delivered_at' => now()]);
        }

        $tracking = $shipment->trackings()->create([
            'branch_id'  => $shipment->branch_id,
            'updated_by' => Auth::id(),
            'status'     => $validated['status'],
            'location'   => $validated['location'] ?? null,
            'remarks'    => $validated['remarks'] ?? null,
            'tracked_at' => $validated['tracked_at'] ?? now(),
        ]);

        return response()->json($tracking->load('branch'));
    }
}
