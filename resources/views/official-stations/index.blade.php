@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h1>Official Stations</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('official-stations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Station
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Region</th>
                            <th>Officer In Charge</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stations as $station)
                            <tr>
                                <td>{{ $station->code }}</td>
                                <td>{{ $station->name }}</td>
                                <td>{{ $station->region->name }}</td>
                                <td>{{ $station->officer_in_charge }}</td>
                                <td>
                                    <span class="badge {{ $station->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $station->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                <div class="d-flex gap-2">
                                    <!-- View Button -->
                                    <div class="action-btn">
                                        <a href="{{ route('official-stations.show', $station) }}" 
                                           class="btn btn-outline-primary btn-action" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Edit Button -->
                                    <div class="action-btn">
                                        <a href="{{ route('official-stations.edit', $station) }}" 
                                           class="btn btn-outline-warning btn-action" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Delete Button -->
                                    <div class="action-btn">
                                        <form action="{{ route('official-stations.destroy', $station) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this official station? This action cannot be undone.');">
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
                                <td colspan="6" class="text-center">No official stations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $stations->firstItem() }} to {{ $stations->lastItem() }} of {{ $stations->total() }} entries
            </div>
            <nav aria-label="Page navigation">
                {{ $stations->onEachSide(1)->links('pagination::bootstrap-4') }}
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
