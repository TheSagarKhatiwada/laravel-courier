<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('branch')->latest()->paginate(20);
        return view('welcome', compact('employees'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);
        $employee = Employee::create($validated);
        return redirect()->route('employees.show', $employee)->with('success', 'Employee created.');
    }

    public function show(Employee $employee)
    {
        $employee->load('branch');
        return view('welcome', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('employee', 'branches'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);
        $employee->update($validated);
        return redirect()->route('employees.show', $employee)->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }
}
