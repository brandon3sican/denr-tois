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
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'first_name', 'direction' => request('sort') === 'first_name' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">
                                Name
                                @if(request('sort') === 'first_name')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'position_id', 'direction' => request('sort') === 'position_id' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">
                                Position
                                @if(request('sort') === 'position_id')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'div_sec_unit_id', 'direction' => request('sort') === 'div_sec_unit_id' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">
                                Division/Unit
                                @if(request('sort') === 'div_sec_unit_id')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'employment_status_id', 'direction' => request('sort') === 'employment_status_id' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">
                                Status
                                @if(request('sort') === 'employment_status_id')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>Actions</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">
                                Created
                                @if(request('sort') === 'created_at')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
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
                            <td>{{ $employee->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} entries
            </div>
            <nav aria-label="Page navigation">
                {{ $employees->onEachSide(1)->links('pagination::bootstrap-4') }}
            </nav>
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
    
    /* Pagination styling */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        color: #0d6efd;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease-in-out;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    .page-link:hover {
        z-index: 2;
        color: #0a58ca;
        background-color: #e9ecef;
        border-color: #dee2e6;
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
