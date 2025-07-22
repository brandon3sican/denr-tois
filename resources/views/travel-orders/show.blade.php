@extends('layouts.app')

@section('title', 'Travel Order Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Travel Order Details: {{ $travelOrder->travel_order_no }}</h5>
        <div class="d-flex gap-2">
            @if(!in_array(strtolower($travelOrder->status), ['cancelled', 'completed']))
            <form action="{{ route('travel-orders.cancel', $travelOrder) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Are you sure you want to cancel this travel order?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-warning btn-sm">
                    <i class="fas fa-times-circle"></i> Cancel Travel Order
                </button>
            </form>
            @endif
            <a href="{{ route('travel-orders.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Travel Order Information</h6>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Travel Order No.:</th>
                        <td>{{ $travelOrder->travel_order_no }}</td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ \Carbon\Carbon::parse($travelOrder->date)->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @php
                                // Get status name, handling both string and object status
                                $statusName = is_string($travelOrder->status) 
                                    ? $travelOrder->status 
                                    : ($travelOrder->status->name ?? 'Unknown');
                                
                                $statusClass = [
                                    'for recommendation' => 'primary',
                                    'for approval' => 'warning',
                                    'approved' => 'success',
                                    'disapproved' => 'danger',
                                    'cancelled' => 'secondary',
                                    'completed' => 'info',
                                ][strtolower($statusName)] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst($statusName) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Employee:</th>
                        <td>{{ $travelOrder->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Region:</th>
                        <td>{{ $travelOrder->region->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{ $travelOrder->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Contact Number:</th>
                        <td>{{ $travelOrder->contact_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $travelOrder->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Position:</th>
                        <td>{{ $travelOrder->position }}</td>
                    </tr>
                    <tr>
                        <th>Division/Section/Unit:</th>
                        <td>{{ $travelOrder->div_sec_unit }}</td>
                    </tr>
                    <tr>
                        <th>Salary:</th>
                        <td>₱{{ number_format($travelOrder->salary, 2) }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Travel Details</h6>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Departure Date:</th>
                        <td>{{ \Carbon\Carbon::parse($travelOrder->departure_date)->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Arrival Date:</th>
                        <td>{{ \Carbon\Carbon::parse($travelOrder->arrival_date)->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Official Station:</th>
                        <td>{{ $travelOrder->official_station }}</td>
                    </tr>
                    <tr>
                        <th>Destination:</th>
                        <td>{{ $travelOrder->destination }}</td>
                    </tr>
                    <tr>
                        <th>Per Diem Expenses:</th>
                        <td>₱{{ number_format($travelOrder->per_diem_expenses, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Assistant/Laborers Allowed:</th>
                        <td>{{ $travelOrder->assistant_or_laborers_allowed ? 'Yes' : 'No' }}</td>
                    </tr>
                    @if($travelOrder->appropriations)
                        <tr>
                            <th>Appropriations:</th>
                            <td>{{ $travelOrder->appropriations }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h6>Purpose of Travel</h6>
                <div class="border p-3 rounded">
                    {!! nl2br(e($travelOrder->purpose_of_travel)) !!}
                </div>
            </div>
        </div>

        @if($travelOrder->remarks)
            <div class="row mt-4">
                <div class="col-12">
                    <h6>Remarks</h6>
                    <div class="border p-3 rounded">
                        {!! nl2br(e($travelOrder->remarks)) !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="row mt-4">
            <div class="col-12">
                <h6>Signatories</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Date/Time Signed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($travelOrder->signatories as $signatory)
                                <tr>
                                    <td>{{ $signatory->employee->full_name ?? 'N/A' }}</td>
                                    <td>{{ $signatory->userType->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($signatory->is_signed)
                                            <span class="badge bg-success">Signed</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($signatory->signed_at)
                                            {{ \Carbon\Carbon::parse($signatory->signed_at)->format('M d, Y h:i A') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(isset($travelOrder->signatures) && (is_countable($travelOrder->signatures) && count($travelOrder->signatures) > 0))
            <div class="row mt-4">
                <div class="col-12">
                    <h6>Signatures</h6>
                    <div class="row">
                        @foreach($travelOrder->signatures as $signature)
                            <div class="col-md-3 text-center mb-3">
                                <div class="border p-2">
                                    @if($signature->signature_path)
                                        <img src="{{ asset('storage/' . $signature->signature_path) }}" alt="Signature" class="img-fluid" style="max-height: 100px;">
                                    @else
                                        <div class="signature-placeholder" style="height: 100px; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;">
                                            <span class="text-muted">No signature</span>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <strong>{{ $signature->employee->full_name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $signature->userType->name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted">
                    Created: {{ $travelOrder->created_at->format('M d, Y h:i A') }}<br>
                    @if($travelOrder->created_at != $travelOrder->updated_at)
                        Last Updated: {{ $travelOrder->updated_at->format('M d, Y h:i A') }}
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .signature-placeholder {
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #ccc;
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add any additional JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Print functionality
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });
    });
</script>
@endpush
@endsection
