@extends('layouts.app')

@section('title', 'New Shipment')
@section('page-title', 'Create Shipment')

@section('content')
<div class="py-4 max-w-5xl">
    <div class="mb-4">
        <a href="{{ route('shipments.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Shipments</a>
    </div>

    <form action="{{ route('shipments.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Sender Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Sender Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="sender_name" value="{{ old('sender_name') }}"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('sender_name') border-red-500 @enderror">
                        @error('sender_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                        <input type="text" name="sender_phone" value="{{ old('sender_phone') }}"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('sender_phone') border-red-500 @enderror">
                        @error('sender_phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                        <textarea name="sender_address" rows="2"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('sender_address') border-red-500 @enderror">{{ old('sender_address') }}</textarea>
                        @error('sender_address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                            <input type="text" name="sender_city" value="{{ old('sender_city') }}"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('sender_city') border-red-500 @enderror">
                            @error('sender_city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
                            <input type="text" name="sender_state" value="{{ old('sender_state') }}"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('sender_state') border-red-500 @enderror">
                            @error('sender_state')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pincode <span class="text-red-500">*</span></label>
                            <input type="text" name="sender_pincode" value="{{ old('sender_pincode') }}"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('sender_pincode') border-red-500 @enderror">
                            @error('sender_pincode')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receiver Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Receiver Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="receiver_name" value="{{ old('receiver_name') }}"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('receiver_name') border-red-500 @enderror">
                        @error('receiver_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                        <input type="text" name="receiver_phone" value="{{ old('receiver_phone') }}"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('receiver_phone') border-red-500 @enderror">
                        @error('receiver_phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                        <textarea name="receiver_address" rows="2"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('receiver_address') border-red-500 @enderror">{{ old('receiver_address') }}</textarea>
                        @error('receiver_address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                            <input type="text" name="receiver_city" value="{{ old('receiver_city') }}"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('receiver_city') border-red-500 @enderror">
                            @error('receiver_city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
                            <input type="text" name="receiver_state" value="{{ old('receiver_state') }}"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('receiver_state') border-red-500 @enderror">
                            @error('receiver_state')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pincode <span class="text-red-500">*</span></label>
                            <input type="text" name="receiver_pincode" value="{{ old('receiver_pincode') }}"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('receiver_pincode') border-red-500 @enderror">
                            @error('receiver_pincode')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipment Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Shipment Details</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Branch <span class="text-red-500">*</span></label>
                            <select name="branch_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('branch_id') border-red-500 @enderror">
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                            <select name="customer_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">Walk-in / None</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg) <span class="text-red-500">*</span></label>
                            <input type="number" name="weight" value="{{ old('weight') }}" step="0.001" min="0.001"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('weight') border-red-500 @enderror">
                            @error('weight')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pieces</label>
                            <input type="number" name="pieces" value="{{ old('pieces', 1) }}" min="1"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content Description</label>
                        <input type="text" name="content" value="{{ old('content') }}"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Declared Value (₹)</label>
                        <input type="number" name="declared_value" value="{{ old('declared_value') }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>

            <!-- Service & Payment -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Service & Payment</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                        <select name="service_type" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="standard" {{ old('service_type') === 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="express" {{ old('service_type') === 'express' ? 'selected' : '' }}>Express</option>
                            <option value="same_day" {{ old('service_type') === 'same_day' ? 'selected' : '' }}>Same Day</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Mode</label>
                        <select name="payment_mode" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="prepaid" {{ old('payment_mode') === 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                            <option value="cod" {{ old('payment_mode') === 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                            <option value="credit" {{ old('payment_mode') === 'credit' ? 'selected' : '' }}>Credit</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">COD Amount (₹)</label>
                        <input type="number" name="cod_amount" value="{{ old('cod_amount') }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                        <textarea name="remarks" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('remarks') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Create Shipment</button>
            <a href="{{ route('shipments.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</div>
@endsection
