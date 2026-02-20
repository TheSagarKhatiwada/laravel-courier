@extends('layouts.app')

@section('title', 'Shipment - ' . $shipment->awb_number)
@section('page-title', 'Shipment Details')

@section('content')
<div class="py-4 max-w-5xl">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('shipments.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Shipments</a>
        <div class="flex gap-2">
            <a href="{{ route('shipments.label', $shipment) }}" class="px-3 py-1.5 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700">🏷️ Label</a>
            <a href="{{ route('shipments.invoice', $shipment) }}" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">🧾 Invoice</a>
            <a href="{{ route('shipments.edit', $shipment) }}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">✏️ Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header Card -->
            <div class="bg-blue-700 text-white rounded-xl p-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-blue-200 text-sm">AWB Number</p>
                        <h1 class="text-2xl font-bold">{{ $shipment->awb_number }}</h1>
                        <p class="text-blue-200 text-sm mt-1">{{ $shipment->branch?->name }} | Booked: {{ $shipment->booking_date?->format('d M Y') }}</p>
                    </div>
                    @php
                        $statusColors = ['booked'=>'bg-gray-200 text-gray-800','picked'=>'bg-blue-200 text-blue-800','in_transit'=>'bg-yellow-200 text-yellow-800','out_for_delivery'=>'bg-orange-200 text-orange-800','delivered'=>'bg-green-200 text-green-800','returned'=>'bg-red-200 text-red-800','cancelled'=>'bg-red-300 text-red-900'];
                        $color = $statusColors[$shipment->status] ?? 'bg-gray-200 text-gray-800';
                    @endphp
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $color }}">{{ ucwords(str_replace('_',' ',$shipment->status)) }}</span>
                </div>
            </div>

            <!-- Sender/Receiver -->
            <div class="bg-white rounded-xl shadow-sm p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 text-sm uppercase tracking-wide">Sender</h3>
                    <p class="font-semibold text-gray-800">{{ $shipment->sender_name }}</p>
                    <p class="text-sm text-gray-500">📞 {{ $shipment->sender_phone }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $shipment->sender_address }}</p>
                    <p class="text-sm text-gray-500">{{ $shipment->sender_city }}, {{ $shipment->sender_state }} - {{ $shipment->sender_pincode }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 text-sm uppercase tracking-wide">Receiver</h3>
                    <p class="font-semibold text-gray-800">{{ $shipment->receiver_name }}</p>
                    <p class="text-sm text-gray-500">📞 {{ $shipment->receiver_phone }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $shipment->receiver_address }}</p>
                    <p class="text-sm text-gray-500">{{ $shipment->receiver_city }}, {{ $shipment->receiver_state }} - {{ $shipment->receiver_pincode }}</p>
                </div>
            </div>

            <!-- Package Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Package Details</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div><p class="text-gray-500">Weight</p><p class="font-semibold">{{ $shipment->weight }} kg</p></div>
                    <div><p class="text-gray-500">Pieces</p><p class="font-semibold">{{ $shipment->pieces ?? 1 }}</p></div>
                    <div><p class="text-gray-500">Service</p><p class="font-semibold">{{ ucwords(str_replace('_',' ',$shipment->service_type ?? 'standard')) }}</p></div>
                    <div><p class="text-gray-500">Payment</p><p class="font-semibold">{{ ucwords($shipment->payment_mode ?? 'prepaid') }}</p></div>
                    <div><p class="text-gray-500">Content</p><p class="font-semibold">{{ $shipment->content ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Declared Value</p><p class="font-semibold">{{ $shipment->declared_value ? '₹'.number_format($shipment->declared_value,2) : '-' }}</p></div>
                    <div><p class="text-gray-500">COD Amount</p><p class="font-semibold">{{ $shipment->cod_amount ? '₹'.number_format($shipment->cod_amount,2) : '-' }}</p></div>
                    <div><p class="text-gray-500">Customer</p><p class="font-semibold">{{ $shipment->customer?->name ?? 'Walk-in' }}</p></div>
                </div>
                @if($shipment->remarks)
                    <div class="mt-4 pt-4 border-t"><p class="text-gray-500 text-sm">Remarks:</p><p class="text-gray-700">{{ $shipment->remarks }}</p></div>
                @endif
            </div>

            <!-- Tracking Timeline -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Tracking History</h3>
                @if($shipment->trackings->count())
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-blue-200"></div>
                    <ul class="space-y-3">
                        @foreach($shipment->trackings as $tracking)
                        <li class="relative pl-10">
                            <div class="absolute left-2.5 top-2 w-3 h-3 rounded-full {{ $loop->first ? 'bg-blue-600' : 'bg-blue-300' }} border-2 border-white"></div>
                            <div class="bg-gray-50 rounded-lg p-3 text-sm">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-semibold text-gray-800">{{ ucwords(str_replace('_',' ',$tracking->status)) }}</span>
                                    <span class="text-xs text-gray-400">{{ $tracking->tracked_at?->format('d M Y h:i A') }}</span>
                                </div>
                                @if($tracking->location)<p class="text-gray-500 text-xs mt-0.5">📍 {{ $tracking->location }}</p>@endif
                                @if($tracking->remarks)<p class="text-gray-500 text-xs">{{ $tracking->remarks }}</p>@endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <p class="text-gray-400 text-sm">No tracking events yet.</p>
                @endif
            </div>
        </div>

        <!-- Right column -->
        <div class="space-y-6">
            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Update Status</h3>
                <form action="{{ route('shipments.update-status', $shipment) }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">New Status</label>
                            <select name="status" class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                @foreach(['booked','picked','in_transit','out_for_delivery','delivered','returned','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $shipment->status === $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Location</label>
                            <input type="text" name="location" placeholder="Current location"
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Remarks</label>
                            <textarea name="remarks" rows="2"
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Status</button>
                    </div>
                </form>
            </div>

            <!-- Delete -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Danger Zone</h3>
                <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" onsubmit="return confirm('Delete this shipment?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">Delete Shipment</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
