@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Contact Us</h1>
        <p class="text-gray-500 mt-3 text-lg">We're here to help. Reach out to us anytime.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-xl shadow-md p-6 text-center">
            <div class="text-4xl mb-3">📞</div>
            <h3 class="font-bold text-gray-800 mb-1">Phone</h3>
            <p class="text-gray-500 text-sm">Mon-Sat, 9am - 6pm</p>
            <a href="tel:18001234567" class="text-blue-600 font-semibold mt-2 block">1800-123-4567</a>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 text-center">
            <div class="text-4xl mb-3">✉️</div>
            <h3 class="font-bold text-gray-800 mb-1">Email</h3>
            <p class="text-gray-500 text-sm">24/7 email support</p>
            <a href="mailto:support@courierms.com" class="text-blue-600 font-semibold mt-2 block">support@courierms.com</a>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 text-center">
            <div class="text-4xl mb-3">📍</div>
            <h3 class="font-bold text-gray-800 mb-1">Head Office</h3>
            <p class="text-gray-500 text-sm">123 Courier Street</p>
            <p class="text-gray-600 font-semibold mt-2">New Delhi, India</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Send us a message</h2>
        <form class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                    <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="john@example.com">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Shipment query, etc.">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Your message..."></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition-colors">Send Message</button>
        </form>
    </div>
</div>
@endsection
