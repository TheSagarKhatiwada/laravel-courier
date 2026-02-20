@extends('layouts.app')

@section('title', 'Ledger - ' . $customer->name)
@section('page-title', 'Customer Ledger')

@section('content')
<div class="py-4 max-w-4xl">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:underline text-sm">← Back to Customer</a>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <h2 class="font-bold text-blue-800">{{ $customer->name }}</h2>
        <p class="text-sm text-blue-600">{{ $customer->code }} | Credit Limit: ₹{{ number_format($customer->credit_limit ?? 0, 2) }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="font-semibold text-gray-700">Transaction Ledger</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Description</th>
                        <th class="px-4 py-3 text-left">Reference</th>
                        <th class="px-4 py-3 text-right">Debit</th>
                        <th class="px-4 py-3 text-right">Credit</th>
                        <th class="px-4 py-3 text-right">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($entries as $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">{{ $entry->transaction_date?->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $entry->description ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $entry->reference ?? '-' }}</td>
                        <td class="px-4 py-3 text-right text-red-600 font-medium">{{ $entry->debit ? '₹'.number_format($entry->debit, 2) : '-' }}</td>
                        <td class="px-4 py-3 text-right text-green-600 font-medium">{{ $entry->credit ? '₹'.number_format($entry->credit, 2) : '-' }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">₹{{ number_format($entry->balance ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">No ledger entries found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($entries->hasPages())
        <div class="px-4 py-4 border-t">{{ $entries->links() }}</div>
        @endif
    </div>
</div>
@endsection
