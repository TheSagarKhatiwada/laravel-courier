@extends('layouts.app')

@section('title', 'Customers')
@section('page-title', 'Customers')

@section('content')
<div class="py-4">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-700">All Customers <span class="text-gray-400 font-normal text-sm">({{ $customers->total() }})</span></h2>
        <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 font-medium">+ New Customer</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Name / Code</th>
                        <th class="px-4 py-3 text-left">Contact</th>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">City</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <a href="{{ route('customers.show', $customer) }}" class="font-medium text-blue-600 hover:underline">{{ $customer->name }}</a>
                            <div class="text-xs text-gray-400">{{ $customer->code }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div>{{ $customer->email ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $customer->phone ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $customer->branch?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $customer->city ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $customer->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                <a href="{{ route('customers.edit', $customer) }}" class="text-gray-600 hover:underline text-xs">Edit</a>
                                <a href="{{ route('customers.ledger', $customer) }}" class="text-purple-600 hover:underline text-xs">Ledger</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">No customers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="px-4 py-4 border-t">{{ $customers->links() }}</div>
        @endif
    </div>
</div>
@endsection
