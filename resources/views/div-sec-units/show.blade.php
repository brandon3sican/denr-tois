@extends('layouts.app')

@section('content')
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h1>{{ $divSecUnit->name }}</h1>
        </div>
        <div class="col-auto">
            <div class="btn-group" role="group">
                <a href="{{ route('div-sec-units.edit', $divSecUnit) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('div-sec-units.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $divSecUnit->name }}</dd>
                        
                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9">{{ $divSecUnit->description ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-3">Created At</dt>
                        <dd class="col-sm-9">{{ $divSecUnit->created_at->format('M d, Y h:i A') }}</dd>
                        
                        <dt class="col-sm-3">Updated At</dt>
                        <dd class="col-sm-9">{{ $divSecUnit->updated_at->format('M d, Y h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Employees ({{ $divSecUnit->employees_count }})</h5>
                </div>
                <div class="card-body">
                    @if($divSecUnit->employees_count > 0)
                        <div class="list-group list-group-flush">
                            @foreach($divSecUnit->employees->take(5) as $employee)
                                <a href="#" class="list-group-item list-group-item-action">
                                    {{ $employee->full_name }}
                                </a>
                            @endforeach
                            
                            @if($divSecUnit->employees_count > 5)
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        +{{ $divSecUnit->employees_count - 5 }} more employees
                                    </small>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0">No employees assigned to this unit.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <form action="{{ route('div-sec-units.destroy', $divSecUnit) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this item? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
@endsection
