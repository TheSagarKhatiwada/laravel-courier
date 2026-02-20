@extends('layouts.public')

@section('title', 'Track Shipment')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
        <span class="text-5xl">🔍</span>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Track Your Shipment</h1>
        <p class="text-gray-500 mt-2">Enter your AWB number to get real-time tracking updates</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <form action="{{ route('track.public') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">AWB / Tracking Number</label>
                <input type="text" name="awb" placeholder="e.g., DEL20240001"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('awb') border-red-500 @enderror"
                    required>
                @error('awb')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors">
                Track Shipment
            </button>
        </form>
    </div>

    <div class="mt-8 bg-blue-50 rounded-xl p-6">
        <h3 class="font-semibold text-blue-800 mb-2">How to Track?</h3>
        <ol class="list-decimal list-inside text-sm text-blue-700 space-y-1">
            <li>Enter your AWB number in the field above</li>
            <li>Click "Track Shipment"</li>
            <li>View real-time status and location updates</li>
        </ol>
    </div>
</div>
@endsection
