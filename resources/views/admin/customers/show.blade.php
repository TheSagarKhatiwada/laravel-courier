@extends('layouts.app')

@section('title', $customer->name)
@section('page-title', 'Customer Details')

@section('content')
<div class="py-4 max-w-4xl">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('customers.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Customers</a>
        <div class="flex gap-2">
            <a href="{{ route('customers.ledger', $customer) }}" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">📒 Ledger</a>
            <a href="{{ route('customers.edit', $customer) }}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">✏️ Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-2xl">👥</div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">{{ $customer->name }}</h1>
                        <p class="text-blue-600 font-medium">{{ $customer->code }}</p>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $customer->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $customer->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-500">Email</p><p class="font-medium">{{ $customer->email ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Phone</p><p class="font-medium">{{ $customer->phone ?? '-' }}</p></div>
                    <div><p class="text-gray-500">City</p><p class="font-medium">{{ $customer->city ?? '-' }}</p></div>
                    <div><p class="text-gray-500">State</p><p class="font-medium">{{ $customer->state ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Pincode</p><p class="font-medium">{{ $customer->pincode ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Branch</p><p class="font-medium">{{ $customer->branch?->name ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Credit Limit</p><p class="font-medium">₹{{ number_format($customer->credit_limit ?? 0, 2) }}</p></div>
                    <div><p class="text-gray-500">GSTIN</p><p class="font-medium">{{ $customer->gstin ?? '-' }}</p></div>
                </div>
                @if($customer->address)
                <div class="mt-4 pt-4 border-t text-sm"><p class="text-gray-500">Address</p><p>{{ $customer->address }}</p></div>
                @endif
            </div>

            <!-- Recent Shipments -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700">Recent Shipments</h3>
                    <a href="{{ route('shipments.index') }}" class="text-xs text-blue-600 hover:underline">View All</a>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-2 text-left">AWB</th>
                            <th class="px-4 py-2 text-left">Receiver</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($customer->shipments as $shipment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2"><a href="{{ route('shipments.show', $shipment) }}" class="text-blue-600 hover:underline font-medium">{{ $shipment->awb_number }}</a></td>
                            <td class="px-4 py-2 text-gray-600">{{ $shipment->receiver_name }}</td>
                            <td class="px-4 py-2"><span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700">{{ ucwords(str_replace('_',' ',$shipment->status)) }}</span></td>
                            <td class="px-4 py-2 text-gray-500">{{ $shipment->booking_date?->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-4 text-center text-gray-400 text-xs">No shipments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('shipments.create') }}?customer_id={{ $customer->id }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">+ New Shipment</a>
                    <a href="{{ route('customers.edit', $customer) }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">Edit Customer</a>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Deactivate this customer?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm hover:bg-red-200">Deactivate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
