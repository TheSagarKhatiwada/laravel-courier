<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Laravel Courier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex-shrink-0 min-h-screen flex flex-col">
        <div class="p-4 border-b border-gray-700">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <span class="text-2xl">📦</span>
                <span class="text-xl font-bold text-white">CourierMS</span>
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                <span>📊</span><span>Dashboard</span>
            </a>
            <a href="{{ route('shipments.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('shipments.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                <span>📦</span><span>Shipments</span>
            </a>
            <a href="{{ route('customers.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('customers.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                <span>👥</span><span>Customers</span>
            </a>
            <a href="{{ route('branches.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('branches.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                <span>🏢</span><span>Branches</span>
            </a>
            <a href="{{ route('rates.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('rates.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                <span>💰</span><span>Rates</span>
            </a>
            <a href="{{ route('employees.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('employees.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                <span>👔</span><span>Employees</span>
            </a>
            <a href="{{ route('reports.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                <span>📈</span><span>Reports</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700">
            <a href="{{ route('home') }}" class="flex items-center space-x-2 text-gray-400 hover:text-white text-sm">
                <span>🌐</span><span>Public Site</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Top Nav -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-3">
                <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ Auth::user()->name ?? 'User' }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif
            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
                    <span>{{ session('info') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-blue-600 hover:text-blue-800 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 px-6 pb-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
