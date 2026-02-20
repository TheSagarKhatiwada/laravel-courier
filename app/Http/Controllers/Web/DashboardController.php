<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Shipment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_shipments'    => Shipment::count(),
            'delivered'          => Shipment::where('status', 'delivered')->count(),
            'in_transit'         => Shipment::where('status', 'in_transit')->count(),
            'pending'            => Shipment::whereIn('status', ['booked', 'picked'])->count(),
            'total_customers'    => Customer::count(),
            'total_branches'     => Branch::where('is_active', true)->count(),
        ];

        $recentShipments = Shipment::with(['branch', 'customer'])->latest()->limit(10)->get();

        return view('welcome', compact('stats', 'recentShipments'));
    }
}
