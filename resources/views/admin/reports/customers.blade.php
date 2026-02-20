@extends('layouts.app')

@section('title', 'Customers Report')
@section('page-title', 'Customers Report')

@section('content')
<div class="py-4">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="font-semibold text-gray-700">All Customers <span class="text-gray-400 font-normal text-sm">({{ $customers->total() }})</span></h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Code</th>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">City</th>
                        <th class="px-4 py-3 text-right">Shipments</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3"><a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:underline font-medium">{{ $customer->name }}</a></td>
                        <td class="px-4 py-3 text-gray-600">{{ $customer->code }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $customer->branch?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $customer->city ?? '-' }}</td>
                        <td class="px-4 py-3 text-right font-medium">{{ $customer->shipments_count }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $customer->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                            </span>
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
