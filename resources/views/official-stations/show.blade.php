@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Official Station Details: {{ $officialStation->name }}</h5>
                    <div class="btn-group">
                        <a href="{{ route('official-stations.edit', $officialStation) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('official-stations.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Station Information</h6>
                            <dl class="row">
                                <dt class="col-sm-4">Code:</dt>
                                <dd class="col-sm-8">{{ $officialStation->code }}</dd>
                                
                                <dt class="col-sm-4">Name:</dt>
                                <dd class="col-sm-8">{{ $officialStation->name }}</dd>
                                
                                <dt class="col-sm-4">Region:</dt>
                                <dd class="col-sm-8">
                                    <a href="{{ route('regions.show', $officialStation->region) }}">
                                        {{ $officialStation->region->name }} ({{ $officialStation->region->code }})
                                    </a>
                                </dd>
                                
                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge {{ $officialStation->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $officialStation->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h6>Contact Information</h6>
                            <dl class="row">
                                <dt class="col-sm-4">Address:</dt>
                                <dd class="col-sm-8">{{ $officialStation->address }}</dd>
                                
                                <dt class="col-sm-4">Contact Number:</dt>
                                <dd class="col-sm-8">{{ $officialStation->contact_number ?? $officialStation->region->contact_number }}</dd>
                                
                                <dt class="col-sm-4">Email:</dt>
                                <dd class="col-sm-8">{{ $officialStation->email ?? $officialStation->region->email }}</dd>
                                
                                <dt class="col-sm-4">Officer In Charge:</dt>
                                <dd class="col-sm-8">{{ $officialStation->officer_in_charge }}</dd>
                                
                                <dt class="col-sm-4">Officer Position:</dt>
                                <dd class="col-sm-8">{{ $officialStation->officer_position }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Created At:</dt>
                                <dd class="col-sm-8">{{ $officialStation->created_at->format('M d, Y h:i A') }}</dd>
                                
                                <dt class="col-sm-4">Updated At:</dt>
                                <dd class="col-sm-8">{{ $officialStation->updated_at->format('M d, Y h:i A') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('regions.show', $officialStation->region) }}" class="btn btn-outline-primary">
                                <i class="fas fa-map-marker-alt"></i> View Region
                            </a>
                        </div>
                        <div>
                            <form action="{{ route('official-stations.destroy', $officialStation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this official station?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete Station
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
