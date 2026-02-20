<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function shipments(Request $request)
    {
        $user = Auth::user();
        $query = Shipment::with(['branch', 'customer'])
            ->when($user->branch_id, fn($q) => $q->where('branch_id', $user->branch_id))
            ->when($request->from_date, fn($q) => $q->whereDate('booking_date', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('booking_date', '<=', $request->to_date))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest('booking_date');

        $shipments = $query->paginate(50)->withQueryString();
        $summary = [
            'total' => $query->count(),
            'delivered' => Shipment::when($user->branch_id, fn($q) => $q->where('branch_id', $user->branch_id))->where('status', 'delivered')->count(),
            'in_transit' => Shipment::when($user->branch_id, fn($q) => $q->where('branch_id', $user->branch_id))->where('status', 'in_transit')->count(),
        ];

        return view('admin.reports.shipments', compact('shipments', 'summary'));
    }

    public function customers(Request $request)
    {
        $customers = Customer::with('branch')
            ->withCount('shipments')
            ->latest()
            ->paginate(30);

        return view('admin.reports.customers', compact('customers'));
    }

    public function employees(Request $request)
    {
        $employees = Employee::with('branch')
            ->latest()
            ->paginate(30);

        return view('admin.reports.employees', compact('employees'));
    }
}
