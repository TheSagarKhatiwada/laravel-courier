@extends('layouts.public')

@section('title', 'Our Branches')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Our Branches</h1>
        <p class="text-gray-500 mt-3 text-lg">Find a branch near you</p>
    </div>

    @if($branches->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($branches as $branch)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start space-x-4">
                    <div class="text-3xl">🏢</div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800">{{ $branch->name }}</h3>
                        <p class="text-sm text-blue-600 font-medium">Code: {{ $branch->code }}</p>
                        @if($branch->address)
                            <p class="text-sm text-gray-500 mt-1">📍 {{ $branch->address }}</p>
                        @endif
                        @if($branch->city || $branch->state)
                            <p class="text-sm text-gray-600">{{ $branch->city }}@if($branch->city && $branch->state), @endif{{ $branch->state }} @if($branch->pincode) - {{ $branch->pincode }}@endif</p>
                        @endif
                        @if($branch->phone)
                            <p class="text-sm text-gray-600 mt-2">📞 <a href="tel:{{ $branch->phone }}" class="text-blue-600 hover:underline">{{ $branch->phone }}</a></p>
                        @endif
                        @if($branch->email)
                            <p class="text-sm text-gray-600">✉️ <a href="mailto:{{ $branch->email }}" class="text-blue-600 hover:underline">{{ $branch->email }}</a></p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <div class="text-5xl mb-4">🏢</div>
            <p class="text-gray-500 text-lg">No active branches at the moment.</p>
        </div>
    @endif
</div>
@endsection
