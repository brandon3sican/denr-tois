<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\DivSecUnit;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['position', 'divSecUnit', 'employmentStatus'])->latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::all();
        $divSecUnits = DivSecUnit::all();
        $employmentStatuses = EmploymentStatus::all();
        
        return view('employees.create', compact('positions', 'divSecUnits', 'employmentStatuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'contact_num' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'date_hired' => 'required|date',
            'position_id' => 'required|exists:positions,id',
            'div_sec_unit_id' => 'required|exists:div_sec_units,id',
            'employment_status_id' => 'required|exists:employment_statuses,id',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['position', 'divSecUnit', 'employmentStatus']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $divSecUnits = DivSecUnit::all();
        $employmentStatuses = EmploymentStatus::all();
        
        return view('employees.edit', compact('employee', 'positions', 'divSecUnits', 'employmentStatuses'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'contact_num' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'date_hired' => 'required|date',
            'position_id' => 'required|exists:positions,id',
            'div_sec_unit_id' => 'required|exists:div_sec_units,id',
            'employment_status_id' => 'required|exists:employment_statuses,id',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully');
    }
}
