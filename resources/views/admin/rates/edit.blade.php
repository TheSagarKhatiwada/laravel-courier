@extends('layouts.app')

@section('title', 'Edit Rate')
@section('page-title', 'Edit Rate')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('rates.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Rates</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('rates.update', $rate) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Branch</label>
                    <input type="text" value="{{ $rate->branch?->name }}" disabled class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                    <input type="text" value="{{ ucwords(str_replace('_',' ',$rate->service_type)) }}" disabled class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Base Price (₹) <span class="text-red-500">*</span></label>
                    <input type="number" name="base_price" value="{{ old('base_price', $rate->base_price) }}" step="0.01" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('base_price') border-red-500 @enderror">
                    @error('base_price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Additional Weight Price (₹/kg)</label>
                    <input type="number" name="additional_weight_price" value="{{ old('additional_weight_price', $rate->additional_weight_price) }}" step="0.01" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fuel Surcharge (%)</label>
                    <input type="number" name="fuel_surcharge_pct" value="{{ old('fuel_surcharge_pct', $rate->fuel_surcharge_pct) }}" step="0.1" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">COD Charge (%)</label>
                    <input type="number" name="cod_charge_pct" value="{{ old('cod_charge_pct', $rate->cod_charge_pct) }}" step="0.1" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $rate->is_active ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Update Rate</button>
                <a href="{{ route('rates.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
