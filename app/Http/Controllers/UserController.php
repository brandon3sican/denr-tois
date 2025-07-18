<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'username');
        $sortDirection = $request->get('direction', 'asc');
        
        $validSortFields = ['username', 'is_admin', 'employee_id'];
        $sortField = in_array($sortField, $validSortFields) ? $sortField : 'username';
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'asc';
        
        $users = User::with('employee')
            ->when($sortField === 'employee_id', function($query) use ($sortDirection) {
                return $query->join('employees', 'users.employee_id', '=', 'employees.id')
                    ->orderBy('employees.last_name', $sortDirection)
                    ->orderBy('employees.first_name', $sortDirection)
                    ->select('users.*');
            })
            ->when($sortField !== 'employee_id', function($query) use ($sortField, $sortDirection) {
                return $query->orderBy($sortField, $sortDirection);
            })
            ->paginate(10)
            ->withQueryString();
            
        return view('users.index', compact('users', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        $employees = \App\Models\Employee::doesntHave('user')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'suffix')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function($employee) {
                $employee->full_name = $employee->full_name;
                return $employee;
            });
            
        return view('users.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'employee_id' => [
                'required',
                'exists:employees,id',
                'unique:users,employee_id',
                function ($attribute, $value, $fail) {
                    $employee = \App\Models\Employee::find($value);
                    if ($employee && $employee->user) {
                        $fail('The selected employee already has a user account.');
                    }
                },
            ],
        ]);

        try {
            $user = new User();
            $user->username = $validated['username'];
            $user->password = Hash::make($validated['password']);
            $user->is_admin = $request->has('is_admin');
            $user->employee_id = $validated['employee_id'];
            $user->save();

            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating user. Please try again.');
        }
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Get all employees that don't have a user account, plus the currently assigned employee
        $employees = \App\Models\Employee::whereDoesntHave('user')
            ->orWhere('id', $user->employee_id)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'suffix')
            ->get()
            ->map(function($employee) {
                $employee->full_name = $employee->full_name;
                return $employee;
            });
            
        return view('users.edit', compact('user', 'employees'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'is_admin' => 'boolean',
            'employee_id' => 'required|exists:employees,id|unique:users,employee_id,' . $user->id
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $validated['is_admin'] = $request->has('is_admin');

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
