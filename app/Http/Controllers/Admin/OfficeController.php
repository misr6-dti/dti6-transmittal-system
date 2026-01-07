<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::latest()->paginate(10);
        return view('admin.offices.index', compact('offices'));
    }

    public function create()
    {
        return view('admin.offices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:offices',
            'type' => 'required|string|max:100',
        ]);

        Office::create($request->all());

        return redirect()->route('admin.offices.index')->with('success', 'Office created successfully.');
    }

    public function edit(Office $office)
    {
        return view('admin.offices.edit', compact('office'));
    }

    public function update(Request $request, Office $office)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:offices,code,'.$office->id,
            'type' => 'required|string|max:100',
        ]);

        $office->update($request->all());

        return redirect()->route('admin.offices.index')->with('success', 'Office updated successfully.');
    }

    public function destroy(Office $office)
    {
        // Add check if office has transmittals or users
        $office->delete();
        return redirect()->route('admin.offices.index')->with('success', 'Office deleted successfully.');
    }
}
