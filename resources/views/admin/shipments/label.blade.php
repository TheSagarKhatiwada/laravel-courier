<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label - {{ $shipment->awb_number }}</title>
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

    <div class="bg-white border-2 border-gray-800 max-w-md mx-auto p-0 font-mono text-sm">
        <!-- Header -->
        <div class="bg-gray-800 text-white px-4 py-2 flex items-center justify-between">
            <span class="text-lg font-bold">📦 CourierMS</span>
            <span class="text-xs">SHIPMENT LABEL</span>
        </div>

        <!-- AWB Barcode Area -->
        <div class="border-b-2 border-dashed border-gray-400 p-4 text-center">
            <div class="text-3xl font-bold tracking-widest">{{ $shipment->awb_number }}</div>
            <div class="text-xs text-gray-500 mt-1">AWB / TRACKING NUMBER</div>
            <div class="mt-2 h-12 bg-gray-800 flex items-end justify-center text-white text-xs pb-1">
                |||||| ||||| |||||||| ||||| ||||||||||||
            </div>
        </div>

        <!-- From / To -->
        <div class="grid grid-cols-2 border-b">
            <div class="p-3 border-r">
                <p class="text-xs text-gray-500 uppercase mb-1">From:</p>
                <p class="font-bold">{{ $shipment->sender_name }}</p>
                <p class="text-xs">{{ $shipment->sender_address }}</p>
                <p class="text-xs">{{ $shipment->sender_city }}, {{ $shipment->sender_state }}</p>
                <p class="text-xs">{{ $shipment->sender_pincode }}</p>
                <p class="text-xs">📞 {{ $shipment->sender_phone }}</p>
            </div>
            <div class="p-3">
                <p class="text-xs text-gray-500 uppercase mb-1">To:</p>
                <p class="font-bold text-lg">{{ $shipment->receiver_name }}</p>
                <p class="text-xs">{{ $shipment->receiver_address }}</p>
                <p class="text-xs">{{ $shipment->receiver_city }}, {{ $shipment->receiver_state }}</p>
                <p class="text-xs font-bold">PIN: {{ $shipment->receiver_pincode }}</p>
                <p class="text-xs">📞 {{ $shipment->receiver_phone }}</p>
            </div>
        </div>

        <!-- Details Row -->
        <div class="grid grid-cols-3 border-b text-center text-xs">
            <div class="p-2 border-r">
                <p class="text-gray-500">WEIGHT</p>
                <p class="font-bold">{{ $shipment->weight }} kg</p>
            </div>
            <div class="p-2 border-r">
                <p class="text-gray-500">SERVICE</p>
                <p class="font-bold">{{ strtoupper($shipment->service_type ?? 'STD') }}</p>
            </div>
            <div class="p-2">
                <p class="text-gray-500">PAYMENT</p>
                <p class="font-bold">{{ strtoupper($shipment->payment_mode ?? 'PPD') }}</p>
            </div>
        </div>

        @if($shipment->cod_amount > 0)
        <div class="p-2 text-center bg-yellow-50 border-b">
            <span class="text-sm font-bold text-orange-700">COD: ₹{{ number_format($shipment->cod_amount, 2) }}</span>
        </div>
        @endif

        <!-- Footer -->
        <div class="p-3 text-center text-xs text-gray-500">
            <p>Booking Date: {{ $shipment->booking_date?->format('d/m/Y') }} | Branch: {{ $shipment->branch?->code }}</p>
            <p class="mt-1">www.courierms.com | support@courierms.com</p>
        </div>
    </div>
</body>
</html>
