@extends('layouts.public')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Fast & Reliable Courier Services</h1>
            <p class="text-xl text-blue-200 mb-8">Track your shipments in real-time. Deliver anywhere, anytime.</p>

            <!-- Track Form -->
            <div class="max-w-xl mx-auto">
                <form action="{{ route('track.public') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="awb" placeholder="Enter AWB / Tracking Number"
                        class="flex-1 px-4 py-3 rounded-lg text-gray-800 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <button type="submit"
                        class="px-6 py-3 bg-yellow-400 text-gray-900 font-bold rounded-lg hover:bg-yellow-300 transition-colors text-lg">
                        Track
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white py-12 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-4xl font-bold text-blue-600">10K+</div>
                    <div class="text-gray-500 mt-1">Shipments Monthly</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600">{{ $branches->count() }}</div>
                    <div class="text-gray-500 mt-1">Active Branches</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600">99%</div>
                    <div class="text-gray-500 mt-1">On-time Delivery</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-orange-600">24/7</div>
                    <div class="text-gray-500 mt-1">Customer Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-md text-center hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-4">🚀</div>
                    <h3 class="text-xl font-semibold mb-2">Express Delivery</h3>
                    <p class="text-gray-500">Next-day delivery for urgent shipments. Fast and secure.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md text-center hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold mb-2">Standard Delivery</h3>
                    <p class="text-gray-500">Economical 2-5 day delivery for regular packages.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md text-center hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold mb-2">Same Day Delivery</h3>
                    <p class="text-gray-500">Deliver within the same day in select cities.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Branches Preview -->
    @if($branches->count())
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Branches</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($branches->take(6) as $branch)
                <div class="border rounded-xl p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start space-x-3">
                        <span class="text-2xl">🏢</span>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $branch->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $branch->city }}, {{ $branch->state }}</p>
                            @if($branch->phone)<p class="text-sm text-blue-600">📞 {{ $branch->phone }}</p>@endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('public.branches') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">View All Branches</a>
            </div>
        </div>
    </section>
    @endif
@endsection
