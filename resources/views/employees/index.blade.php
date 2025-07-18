@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Employees</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Employee
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Division/Unit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->position->name ?? 'N/A' }}</td>
                            <td>{{ $employee->divSecUnit->name ?? 'N/A' }}</td>
                            <td>{{ $employee->employmentStatus->name ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- View Button -->
                                    <div class="action-btn">
                                        <a href="{{ route('employees.show', $employee) }}" 
                                           class="btn btn-outline-primary btn-action" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Edit Button -->
                                    <div class="action-btn">
                                        <a href="{{ route('employees.edit', $employee) }}" 
                                           class="btn btn-outline-warning btn-action" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Delete Button -->
                                    <div class="action-btn">
                                        <form action="{{ route('employees.destroy', $employee) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this employee? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-action" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s ease-in-out;
        border-radius: 4px;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .btn-action:active {
        transform: translateY(0);
    }
    
    .action-btn {
        position: relative;
    }
    
    /* Add a small gap between buttons */
    .action-btn:not(:last-child) {
        margin-right: 4px;
    }
    
    /* Add a subtle background on hover for better visual feedback */
    .action-btn:hover::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background-color: rgba(0, 0, 0, 0.03);
        border-radius: 6px;
        z-index: -1;
    }
    
    /* Disable text selection on buttons */
    .btn-action {
        user-select: none;
        -webkit-user-select: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
