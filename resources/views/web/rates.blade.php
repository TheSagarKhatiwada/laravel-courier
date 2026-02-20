@extends('layouts.public')

@section('title', 'Rates')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Shipping Rates</h1>
        <p class="text-gray-500 mt-3 text-lg">Transparent pricing for all our services</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-gray-400">
            <h3 class="text-lg font-bold text-gray-800 mb-2">📦 Standard</h3>
            <p class="text-3xl font-bold text-gray-700">From ₹50</p>
            <p class="text-sm text-gray-500 mt-1">Per 500g</p>
            <p class="text-sm text-gray-600 mt-3">2-5 business days delivery</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-yellow-400">
            <h3 class="text-lg font-bold text-gray-800 mb-2">🚀 Express</h3>
            <p class="text-3xl font-bold text-yellow-600">From ₹120</p>
            <p class="text-sm text-gray-500 mt-1">Per 500g</p>
            <p class="text-sm text-gray-600 mt-3">Next day delivery</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-green-400">
            <h3 class="text-lg font-bold text-gray-800 mb-2">⚡ Same Day</h3>
            <p class="text-3xl font-bold text-green-600">From ₹250</p>
            <p class="text-sm text-gray-500 mt-1">Per 500g</p>
            <p class="text-sm text-gray-600 mt-3">Within hours delivery</p>
        </div>
    </div>

    @if($rates->count())
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Detailed Rate Chart</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">Service</th>
                        <th class="px-4 py-3 text-left">Origin Zone</th>
                        <th class="px-4 py-3 text-left">Dest Zone</th>
                        <th class="px-4 py-3 text-right">Base Weight</th>
                        <th class="px-4 py-3 text-right">Base Price</th>
                        <th class="px-4 py-3 text-right">Per Extra kg</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($rates as $rate)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $rate->branch?->name ?? 'All' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $rate->service_type === 'express' ? 'bg-yellow-100 text-yellow-800' : ($rate->service_type === 'same_day' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucwords(str_replace('_', ' ', $rate->service_type)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $rate->origin_zone ?? 'Any' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $rate->destination_zone ?? 'Any' }}</td>
                        <td class="px-4 py-3 text-sm text-right text-gray-600">{{ $rate->base_weight }} kg</td>
                        <td class="px-4 py-3 text-sm text-right font-semibold text-gray-800">₹{{ number_format($rate->base_price, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-right text-gray-600">{{ $rate->additional_weight_price ? '₹' . number_format($rate->additional_weight_price, 2) : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="mt-8 bg-blue-50 rounded-xl p-6 text-sm text-blue-800">
        <p>* All prices are exclusive of GST. COD charges apply on cash on delivery orders. Fuel surcharge may apply.</p>
    </div>
</div>
@endsection
