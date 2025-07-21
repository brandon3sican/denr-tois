@extends('layouts.app')

@section('content')
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h1>{{ $position->name }}</h1>
            @if($position->salary_grade)
                <span class="badge bg-secondary">SG {{ $position->salary_grade }}</span>
            @endif
        </div>
        <div class="col-auto">
            <div class="btn-group" role="group">
                <a href="{{ route('positions.edit', $position) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('positions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Position Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Position Name</dt>
                        <dd class="col-sm-9">{{ $position->name }}</dd>
                        
                        @if($position->salary_grade)
                            <dt class="col-sm-3">Salary Grade</dt>
                            <dd class="col-sm-9">SG {{ $position->salary_grade }}</dd>
                        @endif
                        
                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9">{{ $position->description ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-3">Created At</dt>
                        <dd class="col-sm-9">{{ $position->created_at->format('M d, Y h:i A') }}</dd>
                        
                        <dt class="col-sm-3">Updated At</dt>
                        <dd class="col-sm-9">{{ $position->updated_at->format('M d, Y h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Employees ({{ $position->employees_count }})</h5>
                </div>
                <div class="card-body">
                    @if($position->employees_count > 0)
                        <div class="list-group list-group-flush">
                            @foreach($position->employees->take(5) as $employee)
                                <a href="#" class="list-group-item list-group-item-action">
                                    {{ $employee->full_name }}
                                </a>
                            @endforeach
                            
                            @if($position->employees_count > 5)
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        +{{ $position->employees_count - 5 }} more employees
                                    </small>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0">No employees with this position.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <form action="{{ route('positions.destroy', $position) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this position? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-trash"></i> Delete Position
            </button>
        </form>
    </div>
@endsection
