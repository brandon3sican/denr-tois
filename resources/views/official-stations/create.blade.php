@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add New Official Station</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('official-stations.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="region_id" class="form-label">Region *</label>
                            <select class="form-select @error('region_id') is-invalid @enderror" 
                                    id="region_id" name="region_id" required>
                                <option value="">Select Region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" 
                                        {{ old('region_id', request('region_id')) == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }} ({{ $region->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Code *</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                       id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                                <div class="form-text">Leave blank to use region's contact number</div>
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}">
                                <div class="form-text">Leave blank to use region's email</div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="officer_in_charge" class="form-label">Officer In Charge *</label>
                                <input type="text" class="form-control @error('officer_in_charge') is-invalid @enderror" 
                                       id="officer_in_charge" name="officer_in_charge" value="{{ old('officer_in_charge') }}" required>
                                @error('officer_in_charge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="officer_position" class="form-label">Officer Position *</label>
                                <input type="text" class="form-control @error('officer_position') is-invalid @enderror" 
                                       id="officer_position" name="officer_position" value="{{ old('officer_position') }}" required>
                                @error('officer_position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('official-stations.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Station
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-fill contact number and email when region changes
    document.getElementById('region_id').addEventListener('change', function() {
        const regionId = this.value;
        const contactNumberField = document.getElementById('contact_number');
        const emailField = document.getElementById('email');
        
        // Only fetch if the fields are empty
        if (regionId && (!contactNumberField.value || !emailField.value)) {
            fetch(`/api/regions/${regionId}`)
                .then(response => response.json())
                .then(data => {
                    if (!contactNumberField.value) {
                        contactNumberField.value = data.contact_number || '';
                    }
                    if (!emailField.value) {
                        emailField.value = data.email || '';
                    }
                })
                .catch(error => console.error('Error fetching region details:', error));
        }
    });
</script>
@endpush
@endsection
