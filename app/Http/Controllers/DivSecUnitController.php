<?php

namespace App\Http\Controllers;

use App\Models\DivSecUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivSecUnitController extends Controller
{
    public function index()
    {
        $units = DivSecUnit::withCount('employees')
            ->orderBy('name')
            ->paginate(15);
            
        return view('div-sec-units.index', compact('units'));
    }

    public function create()
    {
        return view('div-sec-units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:div_sec_units,name',
            'description' => 'nullable|string|max:500',
        ]);

        DivSecUnit::create($validated);

        return redirect()->route('div-sec-units.index')
            ->with('success', 'Division/Section/Unit created successfully.');
    }

    public function show(DivSecUnit $divSecUnit)
    {
        $divSecUnit->load('employees');
        return view('div-sec-units.show', compact('divSecUnit'));
    }

    public function edit(DivSecUnit $divSecUnit)
    {
        return view('div-sec-units.edit', compact('divSecUnit'));
    }

    public function update(Request $request, DivSecUnit $divSecUnit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:div_sec_units,name,' . $divSecUnit->id,
            'description' => 'nullable|string|max:500',
        ]);

        $divSecUnit->update($validated);

        return redirect()->route('div-sec-units.index')
            ->with('success', 'Division/Section/Unit updated successfully.');
    }

    public function destroy(DivSecUnit $divSecUnit)
    {
        if ($divSecUnit->employees()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete this unit because it has associated employees.');
        }

        $divSecUnit->delete();

        return redirect()->route('div-sec-units.index')
            ->with('success', 'Division/Section/Unit deleted successfully.');
    }
}
