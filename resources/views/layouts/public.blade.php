<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Courier') - Fast & Reliable Delivery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-white text-gray-800 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-blue-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-3xl">📦</span>
                    <span class="text-2xl font-bold">CourierMS</span>
                </a>
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded hover:bg-blue-600 text-sm font-medium {{ request()->routeIs('home') ? 'bg-blue-800' : '' }}">Home</a>
                    <a href="{{ route('track.page') }}" class="px-3 py-2 rounded hover:bg-blue-600 text-sm font-medium {{ request()->routeIs('track.*') ? 'bg-blue-800' : '' }}">Track</a>
                    <a href="{{ route('services') }}" class="px-3 py-2 rounded hover:bg-blue-600 text-sm font-medium {{ request()->routeIs('services') ? 'bg-blue-800' : '' }}">Services</a>
                    <a href="{{ route('public.branches') }}" class="px-3 py-2 rounded hover:bg-blue-600 text-sm font-medium {{ request()->routeIs('public.branches') ? 'bg-blue-800' : '' }}">Branches</a>
                    <a href="{{ route('rates.public') }}" class="px-3 py-2 rounded hover:bg-blue-600 text-sm font-medium {{ request()->routeIs('rates.public') ? 'bg-blue-800' : '' }}">Rates</a>
                    <a href="{{ route('contact') }}" class="px-3 py-2 rounded hover:bg-blue-600 text-sm font-medium {{ request()->routeIs('contact') ? 'bg-blue-800' : '' }}">Contact</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="ml-2 px-4 py-2 bg-white text-blue-700 rounded-lg text-sm font-semibold hover:bg-gray-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="ml-2 px-4 py-2 bg-white text-blue-700 rounded-lg text-sm font-semibold hover:bg-gray-100">Login</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="text-2xl">📦</span>
                        <span class="text-xl font-bold text-white">CourierMS</span>
                    </div>
                    <p class="text-sm">Fast, reliable courier and logistics management for businesses across the country.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('track.page') }}" class="hover:text-white">Track Shipment</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-white">Our Services</a></li>
                        <li><a href="{{ route('rates.public') }}" class="hover:text-white">Rate Calculator</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Services</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Standard Delivery</li>
                        <li>Express Delivery</li>
                        <li>Same Day Delivery</li>
                        <li>Bulk Shipping</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li>📞 1800-123-4567</li>
                        <li>✉️ support@courierms.com</li>
                        <li>🌐 <a href="{{ route('contact') }}" class="hover:text-white">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} CourierMS. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
