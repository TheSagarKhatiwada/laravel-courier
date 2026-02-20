<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount(['shipments', 'employees'])->latest()->paginate(20);
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:branches',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $branch = Branch::create($validated);
        return redirect()->route('branches.show', $branch)->with('success', 'Branch created.');
    }

    public function show(Branch $branch)
    {
        $branch->loadCount(['shipments', 'employees', 'customers']);
        return view('admin.branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'is_active' => 'sometimes|boolean',
        ]);

        $branch->update($validated);
        return redirect()->route('branches.show', $branch)->with('success', 'Branch updated.');
    }

    public function destroy(Branch $branch)
    {
        $branch->update(['is_active' => false]);
        return redirect()->route('branches.index')->with('success', 'Branch deactivated.');
    }
}
