@extends('layouts.app')

@section('title', $employee->name)
@section('page-title', 'Employee Details')

@section('content')
<div class="py-4 max-w-4xl">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('employees.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Employees</a>
        <div class="flex gap-2">
            <a href="{{ route('employees.edit', $employee) }}" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">✏️ Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-2xl">👔</div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">{{ $employee->name }}</h1>
                        <p class="text-blue-600 font-medium">{{ $employee->employee_code }}</p>
                        @php
                            $colors = ['active'=>'bg-green-100 text-green-700','resigned'=>'bg-yellow-100 text-yellow-700','terminated'=>'bg-red-100 text-red-700'];
                            $color = $colors[$employee->status ?? 'active'] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($employee->status ?? 'active') }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-500">Branch</p><p class="font-medium">{{ $employee->branch?->name ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Designation</p><p class="font-medium">{{ $employee->designation ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Department</p><p class="font-medium">{{ $employee->department ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Joining Date</p><p class="font-medium">{{ $employee->joining_date?->format('d M Y') ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Basic Salary</p><p class="font-medium">{{ $employee->basic_salary ? '₹'.number_format($employee->basic_salary,2) : '-' }}</p></div>
                    <div><p class="text-gray-500">Phone</p><p class="font-medium">{{ $employee->phone ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Email</p><p class="font-medium">{{ $employee->email ?? '-' }}</p></div>
                    <div><p class="text-gray-500">Linked User</p><p class="font-medium">{{ $employee->user?->name ?? '-' }}</p></div>
                </div>
                @if($employee->address)
                <div class="mt-4 pt-4 border-t text-sm"><p class="text-gray-500">Address</p><p>{{ $employee->address }}</p></div>
                @endif
            </div>

            <!-- Recent Attendance -->
            @if($employee->attendances && $employee->attendances->count())
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b"><h3 class="font-semibold text-gray-700 text-sm">Recent Attendance</h3></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Check In</th>
                            <th class="px-4 py-2 text-left">Check Out</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($employee->attendances as $att)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-600">{{ $att->date?->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $att->check_in ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $att->check_out ?? '-' }}</td>
                            <td class="px-4 py-2"><span class="text-xs {{ $att->status === 'present' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($att->status ?? '-') }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('employees.edit', $employee) }}" class="block w-full text-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm hover:bg-blue-200">Edit Details</a>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Remove this employee?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm hover:bg-red-200">Remove Employee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
