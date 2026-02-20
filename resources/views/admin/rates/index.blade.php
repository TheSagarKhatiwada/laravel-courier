@extends('layouts.app')

@section('title', 'Rates')
@section('page-title', 'Courier Rates')

@section('content')
<div class="py-4">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-700">All Rates <span class="text-gray-400 font-normal text-sm">({{ $rates->total() }})</span></h2>
        <a href="{{ route('rates.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 font-medium">+ New Rate</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">Service</th>
                        <th class="px-4 py-3 text-left">Origin / Dest</th>
                        <th class="px-4 py-3 text-right">Base Weight</th>
                        <th class="px-4 py-3 text-right">Base Price</th>
                        <th class="px-4 py-3 text-right">Extra kg</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($rates as $rate)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $rate->branch?->name }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $rate->service_type === 'express' ? 'bg-yellow-100 text-yellow-800' : ($rate->service_type === 'same_day' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucwords(str_replace('_',' ',$rate->service_type)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $rate->origin_zone ?? 'Any' }} → {{ $rate->destination_zone ?? 'Any' }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">{{ $rate->base_weight }} kg</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">₹{{ number_format($rate->base_price, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">{{ $rate->additional_weight_price ? '₹'.number_format($rate->additional_weight_price,2) : '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $rate->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $rate->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('rates.edit', $rate) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                                <form action="{{ route('rates.destroy', $rate) }}" method="POST" onsubmit="return confirm('Delete rate?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-10 text-center text-gray-400">No rates found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rates->hasPages())
        <div class="px-4 py-4 border-t">{{ $rates->links() }}</div>
        @endif
    </div>
</div>
@endsection
