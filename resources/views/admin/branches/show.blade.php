@extends('layouts.app')

@section('title', $branch->name)
@section('page-title', 'Branch Details')

@section('content')
<div class="py-4 max-w-3xl">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('branches.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Branches</a>
        <a href="{{ route('branches.edit', $branch) }}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">✏️ Edit</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
                <div class="text-4xl">🏢</div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $branch->name }}</h1>
                    <p class="text-blue-600 font-medium">{{ $branch->code }}</p>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $branch->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $branch->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
            <div><p class="text-gray-500">Address</p><p class="font-medium">{{ $branch->address ?? '-' }}</p></div>
            <div><p class="text-gray-500">City</p><p class="font-medium">{{ $branch->city ?? '-' }}</p></div>
            <div><p class="text-gray-500">State</p><p class="font-medium">{{ $branch->state ?? '-' }}</p></div>
            <div><p class="text-gray-500">Pincode</p><p class="font-medium">{{ $branch->pincode ?? '-' }}</p></div>
            <div><p class="text-gray-500">Phone</p><p class="font-medium">{{ $branch->phone ?? '-' }}</p></div>
            <div><p class="text-gray-500">Email</p><p class="font-medium">{{ $branch->email ?? '-' }}</p></div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $branch->shipments_count ?? 0 }}</div>
            <div class="text-sm text-gray-500 mt-1">Shipments</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $branch->employees_count ?? 0 }}</div>
            <div class="text-sm text-gray-500 mt-1">Employees</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-3xl font-bold text-purple-600">{{ $branch->customers_count ?? 0 }}</div>
            <div class="text-sm text-gray-500 mt-1">Customers</div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Danger Zone</h3>
        <form action="{{ route('branches.destroy', $branch) }}" method="POST" onsubmit="return confirm('Deactivate this branch?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm hover:bg-red-200">Deactivate Branch</button>
        </form>
    </div>
</div>
@endsection
