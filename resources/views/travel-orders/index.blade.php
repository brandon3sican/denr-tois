@extends('layouts.app')

@section('title', 'Travel Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Travel Orders</h1>
    <a href="{{ route('travel-orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create Travel Order
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Travel Order No.</th>
                        <th>Employee</th>
                        <th>Destination</th>
                        <th>Departure Date</th>
                        <th>Arrival Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($travelOrders as $travelOrder)
                        <tr>
                            <td>{{ $travelOrder->travel_order_no }}</td>
                            <td>{{ $travelOrder->full_name }}</td>
                            <td>{{ $travelOrder->destination }}</td>
                            <td>{{ \Carbon\Carbon::parse($travelOrder->departure_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($travelOrder->arrival_date)->format('M d, Y') }}</td>
                            <td>
                                @php
                                    // Get the status name, handling both string and object status
                                    $statusName = is_string($travelOrder->status) 
                                        ? $travelOrder->status 
                                        : ($travelOrder->status->name ?? 'Unknown');
                                        
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'completed' => 'info',
                                        'for recommendation' => 'primary',
                                    ][strtolower($statusName)] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucfirst($statusName) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- View Button -->
                                    <div class="action-btn">
                                        <a href="{{ route('travel-orders.show', $travelOrder) }}" 
                                           class="btn btn-outline-primary btn-action" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Cancel Button (Only show if status is not already cancelled or completed) -->
                                    @if(!in_array(strtolower($statusName), ['cancelled', 'completed']))
                                    <div class="action-btn">
                                        <form action="{{ route('travel-orders.cancel', $travelOrder) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to cancel this travel order?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-outline-warning btn-action" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Cancel">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                    
                                    <!-- Delete Button -->
                                    <div class="action-btn">
                                        <form action="{{ route('travel-orders.destroy', $travelOrder) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this travel order? This action cannot be undone.');">
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
                            <td colspan="7" class="text-center">No travel orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $travelOrders->firstItem() }} to {{ $travelOrders->lastItem() }} of {{ $travelOrders->total() }} entries
            </div>
            <nav aria-label="Page navigation">
                {{ $travelOrders->onEachSide(1)->links('pagination::bootstrap-4') }}
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
