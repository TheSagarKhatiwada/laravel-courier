<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $shipment->awb_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display: none; } body { print-color-adjust: exact; } }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="no-print mb-4 flex gap-2">
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">🖨️ Print</button>
        <a href="{{ route('shipments.show', $shipment) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg text-sm">← Back</a>
    </div>

    <div class="bg-white max-w-2xl mx-auto rounded-xl shadow p-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="text-3xl">📦</span>
                    <span class="text-2xl font-bold text-blue-700">CourierMS</span>
                </div>
                <p class="text-gray-500 text-sm mt-1">123 Courier Street, New Delhi</p>
                <p class="text-gray-500 text-sm">📞 1800-123-4567</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-gray-800">INVOICE</p>
                <p class="text-gray-500 text-sm">AWB: <strong class="text-gray-800">{{ $shipment->awb_number }}</strong></p>
                <p class="text-gray-500 text-sm">Date: {{ $shipment->booking_date?->format('d M Y') }}</p>
            </div>
        </div>

        <!-- From / To -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-2">From</p>
                <p class="font-semibold text-gray-800">{{ $shipment->sender_name }}</p>
                <p class="text-sm text-gray-600">{{ $shipment->sender_address }}</p>
                <p class="text-sm text-gray-600">{{ $shipment->sender_city }}, {{ $shipment->sender_state }} - {{ $shipment->sender_pincode }}</p>
                <p class="text-sm text-gray-600">📞 {{ $shipment->sender_phone }}</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-2">To</p>
                <p class="font-semibold text-gray-800">{{ $shipment->receiver_name }}</p>
                <p class="text-sm text-gray-600">{{ $shipment->receiver_address }}</p>
                <p class="text-sm text-gray-600">{{ $shipment->receiver_city }}, {{ $shipment->receiver_state }} - {{ $shipment->receiver_pincode }}</p>
                <p class="text-sm text-gray-600">📞 {{ $shipment->receiver_phone }}</p>
            </div>
        </div>

        <!-- Shipment Details Table -->
        <table class="w-full text-sm mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600">Description</th>
                    <th class="px-4 py-2 text-right text-gray-600">Weight</th>
                    <th class="px-4 py-2 text-right text-gray-600">Service</th>
                    <th class="px-4 py-2 text-right text-gray-600">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $shipment->content ?? 'General Goods' }}</td>
                    <td class="px-4 py-3 text-right">{{ $shipment->weight }} kg</td>
                    <td class="px-4 py-3 text-right">{{ ucwords(str_replace('_',' ',$shipment->service_type ?? 'standard')) }}</td>
                    <td class="px-4 py-3 text-right font-semibold">₹{{ number_format($shipment->freight_charge ?? 0, 2) }}</td>
                </tr>
                @if($shipment->cod_amount > 0)
                <tr class="border-b bg-yellow-50">
                    <td class="px-4 py-3 text-orange-700">COD Collection</td>
                    <td class="px-4 py-3" colspan="2"></td>
                    <td class="px-4 py-3 text-right font-semibold text-orange-700">₹{{ number_format($shipment->cod_amount, 2) }}</td>
                </tr>
                @endif
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td class="px-4 py-3 font-bold text-gray-800" colspan="3">Total</td>
                    <td class="px-4 py-3 text-right font-bold text-gray-800">₹{{ number_format(($shipment->total_charge ?? $shipment->freight_charge ?? 0), 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Payment Mode -->
        <div class="bg-blue-50 rounded-lg p-4 mb-6 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600">Payment Mode</p>
                <p class="font-semibold text-gray-800">{{ ucwords($shipment->payment_mode ?? 'Prepaid') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Status</p>
                <span class="{{ $shipment->status === 'delivered' ? 'text-green-700' : 'text-yellow-700' }} font-semibold">
                    {{ ucwords(str_replace('_',' ',$shipment->status)) }}
                </span>
            </div>
        </div>

        <div class="text-center text-xs text-gray-400 border-t pt-4">
            <p>Thank you for choosing CourierMS. For queries: support@courierms.com | 1800-123-4567</p>
        </div>
    </div>
</body>
</html>
