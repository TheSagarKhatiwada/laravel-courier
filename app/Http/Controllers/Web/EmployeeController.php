<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['branch', 'user'])->latest()->paginate(20);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $users = User::all();
        return view('admin.employees.create', compact('branches', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'employee_code' => 'required|string|max:20|unique:employees',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'joining_date' => 'required|date',
            'basic_salary' => 'nullable|numeric|min:0',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $employee = Employee::create($validated);
        return redirect()->route('employees.show', $employee)->with('success', 'Employee created.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['branch', 'user', 'attendances' => fn($q) => $q->latest()->limit(10), 'leaves' => fn($q) => $q->latest()->limit(5)]);
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.employees.edit', compact('employee', 'branches'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'basic_salary' => 'nullable|numeric|min:0',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'status' => 'sometimes|in:active,resigned,terminated',
        ]);

        $employee->update($validated);
        return redirect()->route('employees.show', $employee)->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee removed.');
    }
}
