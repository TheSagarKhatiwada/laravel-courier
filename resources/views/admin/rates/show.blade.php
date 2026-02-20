@extends('layouts.app')

@section('title', 'Rate Details')
@section('page-title', 'Rate Details')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('rates.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Rates</a>
        <a href="{{ route('rates.edit', $rate) }}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">✏️ Edit</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-gray-500">Branch</p><p class="font-semibold">{{ $rate->branch?->name }}</p></div>
            <div><p class="text-gray-500">Service Type</p>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                    {{ $rate->service_type === 'express' ? 'bg-yellow-100 text-yellow-800' : ($rate->service_type === 'same_day' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucwords(str_replace('_',' ',$rate->service_type)) }}
                </span>
            </div>
            <div><p class="text-gray-500">Origin Zone</p><p class="font-semibold">{{ $rate->origin_zone ?? 'Any' }}</p></div>
            <div><p class="text-gray-500">Destination Zone</p><p class="font-semibold">{{ $rate->destination_zone ?? 'Any' }}</p></div>
            <div><p class="text-gray-500">Base Weight</p><p class="font-semibold">{{ $rate->base_weight }} kg</p></div>
            <div><p class="text-gray-500">Base Price</p><p class="font-semibold text-lg">₹{{ number_format($rate->base_price, 2) }}</p></div>
            <div><p class="text-gray-500">Additional Weight Price</p><p class="font-semibold">{{ $rate->additional_weight_price ? '₹'.number_format($rate->additional_weight_price,2).'/kg' : '-' }}</p></div>
            <div><p class="text-gray-500">Fuel Surcharge</p><p class="font-semibold">{{ $rate->fuel_surcharge_pct ?? 0 }}%</p></div>
            <div><p class="text-gray-500">COD Charge</p><p class="font-semibold">{{ $rate->cod_charge_pct ?? 0 }}%</p></div>
            <div><p class="text-gray-500">Status</p>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $rate->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $rate->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
