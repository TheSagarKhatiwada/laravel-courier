<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->paginate(20);
        return view('welcome', compact('branches'));
    }

    public function create()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'code'    => 'required|string|max:20|unique:branches',
            'city'    => 'nullable|string|max:100',
            'state'   => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email',
        ]);
        $branch = Branch::create($validated);
        return redirect()->route('branches.show', $branch)->with('success', 'Branch created.');
    }

    public function show(Branch $branch)
    {
        $branch->load(['users', 'employees']);
        return view('welcome', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        return view('welcome', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name'    => 'sometimes|string|max:255',
            'city'    => 'nullable|string|max:100',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email',
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
