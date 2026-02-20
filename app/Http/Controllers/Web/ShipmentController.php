<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $shipments = Shipment::with(['branch', 'customer'])->latest()->paginate(20);
        return view('welcome', compact('shipments'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'        => 'required|exists:branches,id',
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
            'service_type'     => 'nullable|in:standard,express,same_day',
            'payment_mode'     => 'nullable|in:prepaid,cod,credit',
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

        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment created.');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['branch', 'customer', 'trackings']);
        return view('welcome', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('shipment', 'branches'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'weight'   => 'sometimes|numeric|min:0.001',
            'remarks'  => 'nullable|string',
        ]);
        $shipment->update($validated);
        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment updated.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('shipments.index')->with('success', 'Shipment deleted.');
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'status'   => 'required|in:booked,picked,in_transit,out_for_delivery,delivered,returned,cancelled',
            'location' => 'nullable|string',
            'remarks'  => 'nullable|string',
        ]);

        $shipment->update(['status' => $validated['status']]);
        if ($validated['status'] === 'delivered') {
            $shipment->update(['delivered_at' => now()]);
        }
        $shipment->trackings()->create([
            'branch_id'  => $shipment->branch_id,
            'updated_by' => Auth::id(),
            'status'     => $validated['status'],
            'location'   => $validated['location'] ?? null,
            'remarks'    => $validated['remarks'] ?? null,
            'tracked_at' => now(),
        ]);

        return redirect()->route('shipments.show', $shipment)->with('success', 'Status updated.');
    }

    public function label(Shipment $shipment)
    {
        return view('welcome', compact('shipment'));
    }

    public function invoice(Shipment $shipment)
    {
        return view('welcome', compact('shipment'));
    }

    public function bulkUpload(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx,xls|max:10240']);
        return redirect()->route('shipments.index')->with('success', 'File uploaded.');
    }
}
