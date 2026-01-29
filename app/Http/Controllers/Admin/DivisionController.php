<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Office;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::with('office')->latest()->get();
        return view('admin.divisions.index', compact('divisions'));
    }

    public function create()
    {
        $offices = Office::whereNotIn('type', ['Division', 'Satellite'])
                        ->orderBy('code')
                        ->get();
        return view('admin.divisions.create', compact('offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:divisions',
            'office_id' => 'required|exists:offices,id',
        ]);

        Division::create($request->all());

        return redirect()->route('admin.divisions.index')->with('success', 'Division created successfully.');
    }

    public function edit(Division $division)
    {
        $offices = Office::whereNotIn('type', ['Division', 'Satellite'])
                        ->orderBy('code')
                        ->get();
        return view('admin.divisions.edit', compact('division', 'offices'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:divisions,code,'.$division->id,
            'office_id' => 'required|exists:offices,id',
        ]);

        $division->update($request->all());

        return redirect()->route('admin.divisions.index')->with('success', 'Division updated successfully.');
    }

    public function destroy(Division $division)
    {
        // Add check if division has users
        if ($division->users()->exists()) {
            return redirect()->route('admin.divisions.index')
                           ->with('error', 'Cannot delete division with assigned users.');
        }
        
        $division->delete();
        return redirect()->route('admin.divisions.index')->with('success', 'Division deleted successfully.');
    }
}
