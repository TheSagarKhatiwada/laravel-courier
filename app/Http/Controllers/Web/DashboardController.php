<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $stats = [
            'total_shipments' => Shipment::when($branchId, fn($q) => $q->where('branch_id', $branchId))->count(),
            'pending_shipments' => Shipment::when($branchId, fn($q) => $q->where('branch_id', $branchId))->whereNotIn('status', ['delivered', 'returned', 'cancelled'])->count(),
            'delivered_today' => Shipment::when($branchId, fn($q) => $q->where('branch_id', $branchId))->where('status', 'delivered')->whereDate('delivered_at', today())->count(),
            'total_customers' => Customer::when($branchId, fn($q) => $q->where('branch_id', $branchId))->count(),
            'total_branches' => Branch::count(),
            'total_employees' => Employee::when($branchId, fn($q) => $q->where('branch_id', $branchId))->count(),
        ];

        $recentShipments = Shipment::with(['customer', 'branch'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentShipments', 'user'));
    }
}
