<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\DivSecUnit;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $validSortFields = ['first_name', 'last_name', 'position_id', 'div_sec_unit_id', 'employment_status_id', 'created_at'];
        $sortField = in_array($request->get('sort'), $validSortFields) ? $request->get('sort') : 'created_at';
        $sortDirection = $request->get('direction', 'desc');
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc';
        
        $employees = Employee::with(['position', 'divSecUnit', 'employmentStatus'])
            ->when($sortField === 'position_id', function($query) use ($sortDirection) {
                return $query->join('positions', 'employees.position_id', '=', 'positions.id')
                    ->orderBy('positions.name', $sortDirection)
                    ->select('employees.*');
            })
            ->when($sortField === 'div_sec_unit_id', function($query) use ($sortDirection) {
                return $query->join('div_sec_units', 'employees.div_sec_unit_id', '=', 'div_sec_units.id')
                    ->orderBy('div_sec_units.name', $sortDirection)
                    ->select('employees.*');
            })
            ->when($sortField === 'employment_status_id', function($query) use ($sortDirection) {
                return $query->join('employment_statuses', 'employees.employment_status_id', '=', 'employment_statuses.id')
                    ->orderBy('employment_statuses.name', $sortDirection)
                    ->select('employees.*');
            })
            ->when(in_array($sortField, ['first_name', 'last_name', 'created_at']), function($query) use ($sortField, $sortDirection) {
                return $query->orderBy($sortField, $sortDirection);
            })
            ->paginate(10)
            ->withQueryString();
            
        return view('employees.index', compact('employees', 'sortField', 'sortDirection'));
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

        // Create the employee
        $employee = Employee::create($validated);

        // Generate username (firstname.lastname)
        $username = strtolower($validated['first_name'] . '.' . $validated['last_name']);
        $username = preg_replace('/[^a-z0-9.]/', '', $username); // Remove special chars
        
        // Check if username exists and make it unique if needed
        $originalUsername = $username;
        $counter = 1;
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        // Create user account for the employee
        $user = new \App\Models\User();
        $user->username = $username;
        $user->password = \Illuminate\Support\Facades\Hash::make('password123'); // Default password
        $user->is_admin = false; // Default to regular user
        $user->employee_id = $employee->id;
        $user->save();

        return redirect()->route('employees.index')
            ->with('success', 'Employee and user account created successfully. Default password: password123');
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
