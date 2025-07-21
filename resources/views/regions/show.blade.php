@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Region Details: {{ $region->name }}</h5>
                    <div class="btn-group">
                        <a href="{{ route('regions.edit', $region) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('regions.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Region Information</h6>
                            <dl class="row">
                                <dt class="col-sm-4">Code:</dt>
                                <dd class="col-sm-8">{{ $region->code }}</dd>
                                
                                <dt class="col-sm-4">Name:</dt>
                                <dd class="col-sm-8">{{ $region->name }}</dd>
                                
                                <dt class="col-sm-4">Regional Center:</dt>
                                <dd class="col-sm-8">{{ $region->region_center }}</dd>
                                
                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge {{ $region->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $region->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h6>Contact Information</h6>
                            <dl class="row">
                                <dt class="col-sm-4">Address:</dt>
                                <dd class="col-sm-8">{{ $region->address }}</dd>
                                
                                <dt class="col-sm-4">Contact Number:</dt>
                                <dd class="col-sm-8">{{ $region->contact_number ?? 'N/A' }}</dd>
                                
                                <dt class="col-sm-4">Email:</dt>
                                <dd class="col-sm-8">{{ $region->email ?? 'N/A' }}</dd>
                                
                                <dt class="col-sm-4">Created At:</dt>
                                <dd class="col-sm-8">{{ $region->created_at->format('M d, Y h:i A') }}</dd>
                                
                                <dt class="col-sm-4">Updated At:</dt>
                                <dd class="col-sm-8">{{ $region->updated_at->format('M d, Y h:i A') }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Official Stations ({{ $region->officialStations->count() }})</h6>
                            <a href="{{ route('official-stations.create', ['region_id' => $region->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Add Station
                            </a>
                        </div>
                        <div class="card-body p-0">
                            @if($region->officialStations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Officer In Charge</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($region->officialStations as $station)
                                                <tr>
                                                    <td>{{ $station->code }}</td>
                                                    <td>{{ $station->name }}</td>
                                                    <td>{{ $station->officer_in_charge }}</td>
                                                    <td>
                                                        <span class="badge {{ $station->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $station->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('official-stations.show', $station) }}" class="btn btn-sm btn-info" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('official-stations.edit', $station) }}" class="btn btn-sm btn-primary" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-3 text-center text-muted">
                                    No official stations found for this region.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
