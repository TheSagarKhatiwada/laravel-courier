@extends('layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<div class="py-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('reports.shipments') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow group">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-4 rounded-xl text-3xl group-hover:bg-blue-200 transition-colors">📦</div>
                <div>
                    <h3 class="font-bold text-gray-800">Shipments Report</h3>
                    <p class="text-sm text-gray-500 mt-1">View all shipments with filters by date, status, and branch.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('reports.customers') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow group">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 p-4 rounded-xl text-3xl group-hover:bg-green-200 transition-colors">👥</div>
                <div>
                    <h3 class="font-bold text-gray-800">Customers Report</h3>
                    <p class="text-sm text-gray-500 mt-1">Overview of all customers with shipment counts.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('reports.employees') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow group">
            <div class="flex items-center space-x-4">
                <div class="bg-purple-100 p-4 rounded-xl text-3xl group-hover:bg-purple-200 transition-colors">👔</div>
                <div>
                    <h3 class="font-bold text-gray-800">Employees Report</h3>
                    <p class="text-sm text-gray-500 mt-1">Overview of all employees across branches.</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
