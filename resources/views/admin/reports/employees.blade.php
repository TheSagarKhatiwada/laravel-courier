@extends('layouts.app')

@section('title', 'Employees Report')
@section('page-title', 'Employees Report')

@section('content')
<div class="py-4">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="font-semibold text-gray-700">All Employees <span class="text-gray-400 font-normal text-sm">({{ $employees->total() }})</span></h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Code</th>
                        <th class="px-4 py-3 text-left">Branch</th>
                        <th class="px-4 py-3 text-left">Designation</th>
                        <th class="px-4 py-3 text-left">Department</th>
                        <th class="px-4 py-3 text-left">Joining Date</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($employees as $employee)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3"><a href="{{ route('employees.show', $employee) }}" class="text-blue-600 hover:underline font-medium">{{ $employee->name }}</a></td>
                        <td class="px-4 py-3 text-gray-600">{{ $employee->employee_code }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $employee->branch?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $employee->designation ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $employee->department ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $employee->joining_date?->format('d M Y') ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colors = ['active'=>'bg-green-100 text-green-700','resigned'=>'bg-yellow-100 text-yellow-700','terminated'=>'bg-red-100 text-red-700'];
                                $color = $colors[$employee->status ?? 'active'] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($employee->status ?? 'active') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">No employees found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($employees->hasPages())
        <div class="px-4 py-4 border-t">{{ $employees->links() }}</div>
        @endif
    </div>
</div>
@endsection
