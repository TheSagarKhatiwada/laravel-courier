<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function shipments(Request $request)
    {
        $query = Shipment::with(['branch', 'customer'])->latest();

        if ($request->has('from')) {
            $query->whereDate('booking_date', '>=', $request->from);
        }
        if ($request->has('to')) {
            $query->whereDate('booking_date', '<=', $request->to);
        }

        $shipments = $query->paginate(50);
        return view('welcome', compact('shipments'));
    }

    public function customers()
    {
        $customers = Customer::withCount('shipments')->with('branch')->latest()->paginate(50);
        return view('welcome', compact('customers'));
    }

    public function employees()
    {
        $employees = Employee::with('branch')->latest()->paginate(50);
        return view('welcome', compact('employees'));
    }
}
