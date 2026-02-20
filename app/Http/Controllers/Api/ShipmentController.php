<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with(['branch', 'customer', 'trackings'])->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->has('awb')) {
            $query->where('awb_number', 'like', '%' . $request->awb . '%');
        }

        return response()->json($query->paginate(20));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'        => 'required|exists:branches,id',
            'customer_id'      => 'nullable|exists:customers,id',
            'sender_name'      => 'required|string|max:255',
            'sender_phone'     => 'required|string|max:20',
            'sender_address'   => 'required|string',
            'sender_city'      => 'required|string|max:100',
            'sender_state'     => 'required|string|max:100',
            'sender_pincode'   => 'required|string|max:20',
            'receiver_name'    => 'required|string|max:255',
            'receiver_phone'   => 'required|string|max:20',
            'receiver_address' => 'required|string',
            'receiver_city'    => 'required|string|max:100',
            'receiver_state'   => 'required|string|max:100',
            'receiver_pincode' => 'required|string|max:20',
            'weight'           => 'required|numeric|min:0.001',
            'pieces'           => 'nullable|integer|min:1',
            'content'          => 'nullable|string|max:255',
            'declared_value'   => 'nullable|numeric|min:0',
            'service_type'     => 'nullable|in:standard,express,same_day',
            'payment_mode'     => 'nullable|in:prepaid,cod,credit',
            'cod_amount'       => 'nullable|numeric|min:0',
            'remarks'          => 'nullable|string',
        ]);

        $branch = Branch::findOrFail($validated['branch_id']);
        $validated['awb_number']   = Shipment::generateAwb($branch->code);
        $validated['created_by']   = Auth::id();
        $validated['booking_date'] = today();

        $shipment = Shipment::create($validated);

        $shipment->trackings()->create([
            'branch_id'  => $branch->id,
            'updated_by' => Auth::id(),
            'status'     => 'booked',
            'location'   => $branch->city,
            'remarks'    => 'Shipment booked',
            'tracked_at' => now(),
        ]);

        return response()->json($shipment->load(['branch', 'customer', 'trackings']), 201);
    }

    public function show(Shipment $shipment)
    {
        return response()->json($shipment->load(['branch', 'customer', 'trackings.branch', 'createdBy']));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'status'  => 'sometimes|in:booked,picked,in_transit,out_for_delivery,delivered,returned,cancelled',
            'weight'  => 'sometimes|numeric|min:0.001',
            'remarks' => 'nullable|string',
        ]);

        $shipment->update($validated);
        return response()->json($shipment->fresh()->load(['branch', 'customer', 'trackings']));
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return response()->json(['message' => 'Shipment deleted successfully']);
    }

    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'awb_numbers'   => 'required|array',
            'awb_numbers.*' => 'string',
            'status'        => 'required|in:booked,picked,in_transit,out_for_delivery,delivered,returned,cancelled',
            'location'      => 'nullable|string',
            'remarks'       => 'nullable|string',
        ]);

        $shipments = Shipment::whereIn('awb_number', $request->awb_numbers)->get();
        $updated   = 0;

        foreach ($shipments as $shipment) {
            $shipment->update(['status' => $request->status]);
            $shipment->trackings()->create([
                'branch_id'  => $shipment->branch_id,
                'updated_by' => Auth::id(),
                'status'     => $request->status,
                'location'   => $request->location,
                'remarks'    => $request->remarks,
                'tracked_at' => now(),
            ]);
            $updated++;
        }

        return response()->json(['updated' => $updated, 'message' => "{$updated} shipments updated"]);
    }

    public function label(Shipment $shipment)
    {
        return response()->json([
            'awb_number'   => $shipment->awb_number,
            'sender'       => [
                'name'    => $shipment->sender_name,
                'phone'   => $shipment->sender_phone,
                'address' => "{$shipment->sender_address}, {$shipment->sender_city} - {$shipment->sender_pincode}",
            ],
            'receiver'     => [
                'name'    => $shipment->receiver_name,
                'phone'   => $shipment->receiver_phone,
                'address' => "{$shipment->receiver_address}, {$shipment->receiver_city} - {$shipment->receiver_pincode}",
            ],
            'weight'       => $shipment->weight,
            'service_type' => $shipment->service_type,
            'status'       => $shipment->status,
        ]);
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
        ]);

        return response()->json(['message' => 'Bulk upload feature - file received', 'rows' => 0]);
    }
}
