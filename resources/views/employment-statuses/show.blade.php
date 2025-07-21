@extends('layouts.app')

@section('content')
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h1>{{ $employmentStatus->name }}</h1>
            @if($employmentStatus->is_active)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-secondary">Inactive</span>
            @endif
        </div>
        <div class="col-auto">
            <div class="btn-group" role="group">
                <a href="{{ route('employment-statuses.edit', $employmentStatus) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('employment-statuses.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Status Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Status Name</dt>
                        <dd class="col-sm-9">{{ $employmentStatus->name }}</dd>
                        
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
                            @if($employmentStatus->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9">{{ $employmentStatus->description ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-3">Created At</dt>
                        <dd class="col-sm-9">{{ $employmentStatus->created_at->format('M d, Y h:i A') }}</dd>
                        
                        <dt class="col-sm-3">Updated At</dt>
                        <dd class="col-sm-9">{{ $employmentStatus->updated_at->format('M d, Y h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Employees ({{ $employmentStatus->employees_count }})</h5>
                </div>
                <div class="card-body">
                    @if($employmentStatus->employees_count > 0)
                        <div class="list-group list-group-flush">
                            @foreach($employmentStatus->employees->take(5) as $employee)
                                <a href="#" class="list-group-item list-group-item-action">
                                    {{ $employee->full_name }}
                                </a>
                            @endforeach
                            
                            @if($employmentStatus->employees_count > 5)
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        +{{ $employmentStatus->employees_count - 5 }} more employees
                                    </small>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0">No employees with this status.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <form action="{{ route('employment-statuses.destroy', $employmentStatus) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this employment status? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-trash"></i> Delete Employment Status
            </button>
        </form>
    </div>
@endsection
