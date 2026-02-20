@extends('layouts.app')

@section('title', 'Branches')
@section('page-title', 'Branches')

@section('content')
<div class="py-4">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-700">All Branches <span class="text-gray-400 font-normal text-sm">({{ $branches->total() }})</span></h2>
        <a href="{{ route('branches.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 font-medium">+ New Branch</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">Location</th>
                        <th class="px-4 py-3 text-left">Contact</th>
                        <th class="px-4 py-3 text-right">Shipments</th>
                        <th class="px-4 py-3 text-right">Employees</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($branches as $branch)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <a href="{{ route('branches.show', $branch) }}" class="font-medium text-blue-600 hover:underline">{{ $branch->name }}</a>
                            <div class="text-xs text-gray-400">{{ $branch->code }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $branch->city }}@if($branch->city && $branch->state), @endif{{ $branch->state }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            <div>{{ $branch->phone ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $branch->email ?? '' }}</div>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-gray-700">{{ $branch->shipments_count ?? 0 }}</td>
                        <td class="px-4 py-3 text-right font-medium text-gray-700">{{ $branch->employees_count ?? 0 }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $branch->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $branch->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('branches.show', $branch) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                <a href="{{ route('branches.edit', $branch) }}" class="text-gray-600 hover:underline text-xs">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">No branches found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($branches->hasPages())
        <div class="px-4 py-4 border-t">{{ $branches->links() }}</div>
        @endif
    </div>
</div>
@endsection
