<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        return response()->json(Branch::where('is_active', true)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'code'    => 'required|string|max:20|unique:branches',
            'address' => 'nullable|string',
            'city'    => 'nullable|string|max:100',
            'state'   => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email',
            'lat'     => 'nullable|numeric',
            'lng'     => 'nullable|numeric',
        ]);

        $branch = Branch::create($validated);
        return response()->json($branch, 201);
    }

    public function show(Branch $branch)
    {
        return response()->json($branch->load(['users', 'employees']));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name'      => 'sometimes|string|max:255',
            'address'   => 'nullable|string',
            'city'      => 'nullable|string|max:100',
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email',
            'is_active' => 'sometimes|boolean',
        ]);

        $branch->update($validated);
        return response()->json($branch);
    }

    public function destroy(Branch $branch)
    {
        $branch->update(['is_active' => false]);
        return response()->json(['message' => 'Branch deactivated']);
    }
}
