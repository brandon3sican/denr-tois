<?php

namespace App\Http\Controllers;

use App\Models\EmploymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $statuses = EmploymentStatus::withCount('employees')
            ->orderBy('name')
            ->paginate(15);
            
        return view('employment-statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('employment-statuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:employment_statuses,name',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        EmploymentStatus::create($validated);

        return redirect()->route('employment-statuses.index')
            ->with('success', 'Employment status created successfully.');
    }

    public function show(EmploymentStatus $employmentStatus)
    {
        $employmentStatus->load('employees');
        return view('employment-statuses.show', compact('employmentStatus'));
    }

    public function edit(EmploymentStatus $employmentStatus)
    {
        return view('employment-statuses.edit', compact('employmentStatus'));
    }

    public function update(Request $request, EmploymentStatus $employmentStatus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:employment_statuses,name,' . $employmentStatus->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $employmentStatus->update($validated);

        return redirect()->route('employment-statuses.index')
            ->with('success', 'Employment status updated successfully.');
    }

    public function destroy(EmploymentStatus $employmentStatus)
    {
        if ($employmentStatus->employees()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete this employment status because it has associated employees.');
        }

        $employmentStatus->delete();

        return redirect()->route('employment-statuses.index')
            ->with('success', 'Employment status deleted successfully.');
    }
}
