<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Shipment::with(['branch', 'customer'])->latest();

        if ($user->branch_id) {
            $query->where('branch_id', $user->branch_id);
        }
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('awb_number', 'like', "%{$search}%")
                  ->orWhere('sender_name', 'like', "%{$search}%")
                  ->orWhere('receiver_name', 'like', "%{$search}%")
                  ->orWhere('receiver_phone', 'like', "%{$search}%");
            });
        }

        $shipments = $query->paginate(20)->withQueryString();
        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $customers = Customer::where('is_active', true)->get();
        return view('admin.shipments.create', compact('branches', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'customer_id' => 'nullable|exists:customers,id',
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:20',
            'sender_address' => 'required|string',
            'sender_city' => 'required|string|max:100',
            'sender_state' => 'required|string|max:100',
            'sender_pincode' => 'required|string|max:20',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_address' => 'required|string',
            'receiver_city' => 'required|string|max:100',
            'receiver_state' => 'required|string|max:100',
            'receiver_pincode' => 'required|string|max:20',
            'weight' => 'required|numeric|min:0.001',
            'pieces' => 'nullable|integer|min:1',
            'content' => 'nullable|string|max:255',
            'declared_value' => 'nullable|numeric|min:0',
            'service_type' => 'nullable|in:standard,express,same_day',
            'payment_mode' => 'nullable|in:prepaid,cod,credit',
            'cod_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $branch = Branch::findOrFail($validated['branch_id']);
        $validated['awb_number'] = Shipment::generateAwb($branch->code);
        $validated['created_by'] = Auth::id();
        $validated['booking_date'] = today();

        $shipment = Shipment::create($validated);
        $shipment->trackings()->create([
            'branch_id' => $branch->id,
            'updated_by' => Auth::id(),
            'status' => 'booked',
            'location' => $branch->city,
            'remarks' => 'Shipment booked',
            'tracked_at' => now(),
        ]);

        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment created successfully. AWB: ' . $shipment->awb_number);
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['branch', 'customer', 'trackings.branch', 'createdBy']);
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $branches = Branch::where('is_active', true)->get();
        $customers = Customer::where('is_active', true)->get();
        return view('admin.shipments.edit', compact('shipment', 'branches', 'customers'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:booked,picked,in_transit,out_for_delivery,delivered,returned,cancelled',
            'weight' => 'sometimes|numeric|min:0.001',
            'remarks' => 'nullable|string',
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
        $request->validate([
            'status' => 'required|in:booked,picked,in_transit,out_for_delivery,delivered,returned,cancelled',
            'location' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $shipment->update(['status' => $request->status]);
        if ($request->status === 'delivered') {
            $shipment->update(['delivered_at' => now()]);
        }

        $shipment->trackings()->create([
            'branch_id' => $shipment->branch_id,
            'updated_by' => Auth::id(),
            'status' => $request->status,
            'location' => $request->location,
            'remarks' => $request->remarks,
            'tracked_at' => now(),
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    public function label(Shipment $shipment)
    {
        return view('admin.shipments.label', compact('shipment'));
    }

    public function invoice(Shipment $shipment)
    {
        return view('admin.shipments.invoice', compact('shipment'));
    }

    public function bulkUpload(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx,xls|max:10240']);
        return back()->with('info', 'Bulk upload feature coming soon.');
    }
}
