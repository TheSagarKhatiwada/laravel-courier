@extends('layouts.app')

@section('title', 'Edit Shipment')
@section('page-title', 'Edit Shipment')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('shipments.show', $shipment) }}" class="text-blue-600 hover:underline text-sm">← Back to Shipment</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Edit Shipment: <span class="text-blue-600">{{ $shipment->awb_number }}</span></h3>

        <form action="{{ route('shipments.update', $shipment) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @foreach(['booked','picked','in_transit','out_for_delivery','delivered','returned','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $shipment->status === $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $shipment->weight) }}" step="0.001" min="0.001"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('weight') border-red-500 @enderror">
                    @error('weight')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                    <textarea name="remarks" rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('remarks', $shipment->remarks) }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Update</button>
                <a href="{{ route('shipments.show', $shipment) }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
