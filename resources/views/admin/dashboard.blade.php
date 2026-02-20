@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="py-4">

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
            <div class="bg-blue-100 p-3 rounded-lg"><span class="text-3xl">📦</span></div>
            <div>
                <p class="text-sm text-gray-500">Total Shipments</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_shipments']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
            <div class="bg-yellow-100 p-3 rounded-lg"><span class="text-3xl">⏳</span></div>
            <div>
                <p class="text-sm text-gray-500">Pending Shipments</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['pending_shipments']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
            <div class="bg-green-100 p-3 rounded-lg"><span class="text-3xl">✅</span></div>
            <div>
                <p class="text-sm text-gray-500">Delivered Today</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['delivered_today']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
            <div class="bg-purple-100 p-3 rounded-lg"><span class="text-3xl">👥</span></div>
            <div>
                <p class="text-sm text-gray-500">Total Customers</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_customers']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
            <div class="bg-indigo-100 p-3 rounded-lg"><span class="text-3xl">🏢</span></div>
            <div>
                <p class="text-sm text-gray-500">Total Branches</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_branches']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-4">
            <div class="bg-orange-100 p-3 rounded-lg"><span class="text-3xl">👔</span></div>
            <div>
                <p class="text-sm text-gray-500">Total Employees</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_employees']) }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('shipments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm">+ New Shipment</a>
        <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-sm">+ New Customer</a>
        <a href="{{ route('track.page') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium text-sm">🔍 Track Shipment</a>
        <a href="{{ route('reports.shipments') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium text-sm">📈 Reports</a>
    </div>

    <!-- Recent Shipments -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h2 class="font-semibold text-gray-800">Recent Shipments</h2>
            <a href="{{ route('shipments.index') }}" class="text-sm text-blue-600 hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">AWB</th>
                        <th class="px-4 py-3 text-left">Sender</th>
                        <th class="px-4 py-3 text-left">Receiver</th>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($recentShipments as $shipment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <a href="{{ route('shipments.show', $shipment) }}" class="font-medium text-blue-600 hover:underline">{{ $shipment->awb_number }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $shipment->sender_name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $shipment->receiver_name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $shipment->branch?->name }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = ['booked'=>'bg-gray-100 text-gray-700','picked'=>'bg-blue-100 text-blue-700','in_transit'=>'bg-yellow-100 text-yellow-700','out_for_delivery'=>'bg-orange-100 text-orange-700','delivered'=>'bg-green-100 text-green-700','returned'=>'bg-red-100 text-red-700','cancelled'=>'bg-red-200 text-red-800'];
                                $color = $statusColors[$shipment->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucwords(str_replace('_',' ',$shipment->status)) }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $shipment->booking_date?->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No shipments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
