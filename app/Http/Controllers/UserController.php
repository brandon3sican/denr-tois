<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Http\Requests\UserRequest;
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

    public function store(UserRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            
            User::create($validated);

            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $employees = Employee::select('id', 'first_name', 'middle_name', 'last_name', 'suffix')
            ->where(function($query) use ($user) {
                $query->whereDoesntHave('user')
                    ->orWhere('id', $user->employee_id);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function($employee) {
                $employee->full_name = $employee->full_name;
                return $employee;
            });
            
        return view('users.edit', compact('user', 'employees'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();
            
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
