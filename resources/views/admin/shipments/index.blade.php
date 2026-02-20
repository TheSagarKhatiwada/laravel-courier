@extends('layouts.app')

@section('title', 'Shipments')
@section('page-title', 'Shipments')

@section('content')
<div class="py-4">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="AWB, name, phone..."
                    class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-52">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select name="status" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">All Status</option>
                    @foreach(['booked','picked','in_transit','out_for_delivery','delivered','returned','cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Filter</button>
            <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">Clear</a>
            <div class="ml-auto">
                <a href="{{ route('shipments.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 font-medium">+ New Shipment</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h2 class="font-semibold text-gray-800">All Shipments <span class="text-gray-400 font-normal text-sm">({{ $shipments->total() }})</span></h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">AWB</th>
                        <th class="px-4 py-3 text-left">Sender</th>
                        <th class="px-4 py-3 text-left">Receiver</th>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">Weight</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($shipments as $shipment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <a href="{{ route('shipments.show', $shipment) }}" class="font-semibold text-blue-600 hover:underline">{{ $shipment->awb_number }}</a>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $shipment->sender_name }}</div>
                            <div class="text-xs text-gray-400">{{ $shipment->sender_city }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $shipment->receiver_name }}</div>
                            <div class="text-xs text-gray-400">{{ $shipment->receiver_city }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $shipment->branch?->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $shipment->weight }} kg</td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = ['booked'=>'bg-gray-100 text-gray-700','picked'=>'bg-blue-100 text-blue-700','in_transit'=>'bg-yellow-100 text-yellow-700','out_for_delivery'=>'bg-orange-100 text-orange-700','delivered'=>'bg-green-100 text-green-700','returned'=>'bg-red-100 text-red-700','cancelled'=>'bg-red-200 text-red-800'];
                                $color = $statusColors[$shipment->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucwords(str_replace('_',' ',$shipment->status)) }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $shipment->booking_date?->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('shipments.show', $shipment) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                <a href="{{ route('shipments.label', $shipment) }}" class="text-gray-600 hover:underline text-xs">Label</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-10 text-center text-gray-400">No shipments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($shipments->hasPages())
        <div class="px-4 py-4 border-t">
            {{ $shipments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
