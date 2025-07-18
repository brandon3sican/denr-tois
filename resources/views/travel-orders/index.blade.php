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
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'completed' => 'info',
                                    ][strtolower($travelOrder->status->name)] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $travelOrder->status->name }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('travel-orders.show', $travelOrder) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('travel-orders.edit', $travelOrder) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('travel-orders.destroy', $travelOrder) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this travel order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
        
        <div class="d-flex justify-content-center mt-4">
            {{ $travelOrders->links() }}
        </div>
    </div>
</div>
@endsection
