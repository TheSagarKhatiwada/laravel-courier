@extends('layouts.public')

@section('title', 'Our Services')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Our Services</h1>
        <p class="text-gray-500 mt-3 text-lg">Comprehensive courier and logistics solutions for every need</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition-shadow border-t-4 border-blue-500">
            <div class="text-5xl mb-4">📦</div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Standard Delivery</h3>
            <p class="text-gray-500 mb-4">Economical delivery service. 2-5 business days. Best for non-urgent shipments.</p>
            <ul class="text-sm text-gray-600 space-y-2 text-left">
                <li>✅ Pan India coverage</li>
                <li>✅ Real-time tracking</li>
                <li>✅ Insurance available</li>
                <li>✅ COD available</li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition-shadow border-t-4 border-yellow-500">
            <div class="text-5xl mb-4">🚀</div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Express Delivery</h3>
            <p class="text-gray-500 mb-4">Next business day delivery. For urgent shipments that can't wait.</p>
            <ul class="text-sm text-gray-600 space-y-2 text-left">
                <li>✅ Next day delivery</li>
                <li>✅ Priority handling</li>
                <li>✅ SMS notifications</li>
                <li>✅ Dedicated support</li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition-shadow border-t-4 border-green-500">
            <div class="text-5xl mb-4">⚡</div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Same Day Delivery</h3>
            <p class="text-gray-500 mb-4">Delivery within hours. Available in select cities for critical packages.</p>
            <ul class="text-sm text-gray-600 space-y-2 text-left">
                <li>✅ Within 4-8 hours</li>
                <li>✅ Live tracking</li>
                <li>✅ Proof of delivery</li>
                <li>✅ Select cities only</li>
            </ul>
        </div>
    </div>

    <div class="bg-blue-700 rounded-2xl text-white p-12 text-center">
        <h2 class="text-3xl font-bold mb-3">Ready to Ship?</h2>
        <p class="text-blue-200 mb-6">Book your shipment online or visit your nearest branch.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-blue-700 rounded-lg font-semibold hover:bg-gray-100">Book Now</a>
            <a href="{{ route('public.branches') }}" class="px-8 py-3 border-2 border-white text-white rounded-lg font-semibold hover:bg-blue-600">Find Branch</a>
        </div>
    </div>
</div>
@endsection
