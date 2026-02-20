@extends('layouts.app')

@section('title', 'New Rate')
@section('page-title', 'Create Rate')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('rates.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Rates</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('rates.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Branch <span class="text-red-500">*</span></label>
                    <select name="branch_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('branch_id') border-red-500 @enderror">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Type <span class="text-red-500">*</span></label>
                    <select name="service_type" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('service_type') border-red-500 @enderror">
                        <option value="standard" {{ old('service_type') === 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="express" {{ old('service_type') === 'express' ? 'selected' : '' }}>Express</option>
                        <option value="same_day" {{ old('service_type') === 'same_day' ? 'selected' : '' }}>Same Day</option>
                    </select>
                    @error('service_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Origin Zone</label>
                    <input type="text" name="origin_zone" value="{{ old('origin_zone') }}"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="e.g., North">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Destination Zone</label>
                    <input type="text" name="destination_zone" value="{{ old('destination_zone') }}"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="e.g., South">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Base Weight (kg) <span class="text-red-500">*</span></label>
                    <input type="number" name="base_weight" value="{{ old('base_weight', 0.5) }}" step="0.1" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('base_weight') border-red-500 @enderror">
                    @error('base_weight')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Base Price (₹) <span class="text-red-500">*</span></label>
                    <input type="number" name="base_price" value="{{ old('base_price') }}" step="0.01" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('base_price') border-red-500 @enderror">
                    @error('base_price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Additional Weight Price (₹/kg)</label>
                    <input type="number" name="additional_weight_price" value="{{ old('additional_weight_price') }}" step="0.01" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fuel Surcharge (%)</label>
                    <input type="number" name="fuel_surcharge_pct" value="{{ old('fuel_surcharge_pct', 0) }}" step="0.1" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">COD Charge (%)</label>
                    <input type="number" name="cod_charge_pct" value="{{ old('cod_charge_pct', 0) }}" step="0.1" min="0"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Create Rate</button>
                <a href="{{ route('rates.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
