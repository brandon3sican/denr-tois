@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Employee Details</h5>
        <div>
            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Personal Information</h6>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Full Name:</th>
                        <td>{{ $employee->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td>{{ ucfirst($employee->gender) }}</td>
                    </tr>
                    <tr>
                        <th>Birthdate:</th>
                        <td>{{ \Carbon\Carbon::parse($employee->birthdate)->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td>{{ $employee->age }} years old</td>
                    </tr>
                    <tr>
                        <th>Contact Number:</th>
                        <td>{{ $employee->contact_num }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{ $employee->address }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Employment Details</h6>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Position:</th>
                        <td>{{ $employee->position->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Division/Section/Unit:</th>
                        <td>{{ $employee->divSecUnit->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Employment Status:</th>
                        <td>{{ $employee->employmentStatus->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Date Hired:</th>
                        <td>{{ \Carbon\Carbon::parse($employee->date_hired)->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Years of Service:</th>
                        <td>{{ \Carbon\Carbon::parse($employee->date_hired)->diffInYears(now()) }} years</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h6>Travel Orders</h6>
            @if($employee->travelOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Travel Order No.</th>
                                <th>Destination</th>
                                <th>Purpose</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employee->travelOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('travel-orders.show', $order) }}">
                                            {{ $order->travel_order_no }}
                                        </a>
                                    </td>
                                    <td>{{ $order->destination }}</td>
                                    <td>{{ Str::limit($order->purpose_of_travel, 30) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->departure_date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->arrival_date)->format('M d, Y') }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                'completed' => 'info',
                                            ][strtolower($order->status->name)] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ $order->status->name }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No travel orders found for this employee.</div>
            @endif
        </div>
    </div>
</div>
@endsection
