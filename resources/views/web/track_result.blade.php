@extends('layouts.public')

@section('title', 'Tracking Result - ' . $awb)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="mb-6">
        <a href="{{ route('track.page') }}" class="text-blue-600 hover:underline text-sm">← Track Another Shipment</a>
    </div>

    @if($shipment)
        <!-- Shipment Found -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-700 text-white p-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-blue-200 text-sm">AWB Number</p>
                        <h1 class="text-2xl font-bold">{{ $shipment->awb_number }}</h1>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'booked' => 'bg-gray-200 text-gray-800',
                                'picked' => 'bg-blue-200 text-blue-800',
                                'in_transit' => 'bg-yellow-200 text-yellow-800',
                                'out_for_delivery' => 'bg-orange-200 text-orange-800',
                                'delivered' => 'bg-green-200 text-green-800',
                                'returned' => 'bg-red-200 text-red-800',
                                'cancelled' => 'bg-red-300 text-red-900',
                            ];
                            $color = $statusColors[$shipment->status] ?? 'bg-gray-200 text-gray-800';
                        @endphp
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $color }}">
                            {{ ucwords(str_replace('_', ' ', $shipment->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 border-b">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Sender</h3>
                    <p class="text-gray-800 font-medium">{{ $shipment->sender_name }}</p>
                    <p class="text-gray-500 text-sm">{{ $shipment->sender_city }}, {{ $shipment->sender_state }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Recipient</h3>
                    <p class="text-gray-800 font-medium">{{ $shipment->receiver_name }}</p>
                    <p class="text-gray-500 text-sm">{{ $shipment->receiver_city }}, {{ $shipment->receiver_state }}</p>
                    <p class="text-gray-500 text-sm">📞 {{ $shipment->receiver_phone }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Package Info</h3>
                    <p class="text-sm text-gray-600">Weight: <span class="font-medium">{{ $shipment->weight }} kg</span></p>
                    <p class="text-sm text-gray-600">Pieces: <span class="font-medium">{{ $shipment->pieces ?? 1 }}</span></p>
                    <p class="text-sm text-gray-600">Service: <span class="font-medium">{{ ucwords(str_replace('_', ' ', $shipment->service_type ?? 'standard')) }}</span></p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Booking Info</h3>
                    <p class="text-sm text-gray-600">Booked: <span class="font-medium">{{ $shipment->booking_date?->format('d M Y') }}</span></p>
                    @if($shipment->delivered_at)
                        <p class="text-sm text-green-600">Delivered: <span class="font-medium">{{ $shipment->delivered_at->format('d M Y h:i A') }}</span></p>
                    @endif
                    <p class="text-sm text-gray-600">Branch: <span class="font-medium">{{ $shipment->branch?->name }}</span></p>
                </div>
            </div>

            <!-- Tracking Timeline -->
            <div class="p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Tracking History</h3>
                @if($shipment->trackings->count())
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-blue-200"></div>
                        <ul class="space-y-4">
                            @foreach($shipment->trackings as $tracking)
                            <li class="relative pl-10">
                                <div class="absolute left-2.5 top-1 w-3 h-3 rounded-full {{ $loop->first ? 'bg-blue-600' : 'bg-blue-300' }} border-2 border-white"></div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <span class="font-medium text-gray-800">{{ ucwords(str_replace('_', ' ', $tracking->status)) }}</span>
                                        <span class="text-xs text-gray-400">{{ $tracking->tracked_at?->format('d M Y h:i A') }}</span>
                                    </div>
                                    @if($tracking->location)
                                        <p class="text-sm text-gray-500 mt-1">📍 {{ $tracking->location }}</p>
                                    @endif
                                    @if($tracking->remarks)
                                        <p class="text-sm text-gray-500">{{ $tracking->remarks }}</p>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No tracking updates available yet.</p>
                @endif
            </div>
        </div>
    @else
        <!-- Shipment Not Found -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="text-6xl mb-4">😕</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Shipment Not Found</h2>
            <p class="text-gray-500 mb-6">No shipment found with AWB number <strong>{{ $awb }}</strong>.</p>
            <a href="{{ route('track.page') }}"
                class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                Try Again
            </a>
        </div>
    @endif
</div>
@endsection
