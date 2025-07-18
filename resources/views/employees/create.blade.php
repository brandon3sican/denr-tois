@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Create New Employee</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="first_name" class="form-label">First Name *</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                           id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                           id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                    @error('middle_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3">
                    <label for="last_name" class="form-label">Last Name *</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                           id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-1">
                    <label for="suffix" class="form-label">Suffix</label>
                    <input type="text" class="form-control @error('suffix') is-invalid @enderror" 
                           id="suffix" name="suffix" value="{{ old('suffix') }}">
                    @error('suffix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="age" class="form-label">Age *</label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                           id="age" name="age" value="{{ old('age') }}" min="18" max="100" required>
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-2">
                    <label for="gender" class="form-label">Gender *</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                        <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="birthdate" class="form-label">Birthdate *</label>
                    <input type="date" class="form-control @error('birthdate') is-invalid @enderror" 
                           id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
                    @error('birthdate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="date_hired" class="form-label">Date Hired *</label>
                    <input type="date" class="form-control @error('date_hired') is-invalid @enderror" 
                           id="date_hired" name="date_hired" value="{{ old('date_hired') }}" required>
                    @error('date_hired')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address *</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="contact_num" class="form-label">Contact Number *</label>
                    <input type="text" class="form-control @error('contact_num') is-invalid @enderror" 
                           id="contact_num" name="contact_num" value="{{ old('contact_num') }}" required>
                    @error('contact_num')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="position_id" class="form-label">Position *</label>
                    <select class="form-select @error('position_id') is-invalid @enderror" id="position_id" name="position_id" required>
                        <option value="" disabled selected>Select Position</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('position_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="div_sec_unit_id" class="form-label">Division/Section/Unit *</label>
                    <select class="form-select @error('div_sec_unit_id') is-invalid @enderror" id="div_sec_unit_id" name="div_sec_unit_id" required>
                        <option value="" disabled selected>Select Division/Section/Unit</option>
                        @foreach($divSecUnits as $unit)
                            <option value="{{ $unit->id }}" {{ old('div_sec_unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('div_sec_unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="employment_status_id" class="form-label">Employment Status *</label>
                    <select class="form-select @error('employment_status_id') is-invalid @enderror" id="employment_status_id" name="employment_status_id" required>
                        <option value="" disabled selected>Select Employment Status</option>
                        @foreach($employmentStatuses as $status)
                            <option value="{{ $status->id }}" {{ old('employment_status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employment_status_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Employee
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any client-side validation or behavior here
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate age based on birthdate
        const birthdateInput = document.getElementById('birthdate');
        const ageInput = document.getElementById('age');
        
        if (birthdateInput && ageInput) {
            birthdateInput.addEventListener('change', function() {
                const birthdate = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - birthdate.getFullYear();
                const monthDiff = today.getMonth() - birthdate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                    age--;
                }
                
                ageInput.value = age;
            });
        }
    });
</script>
@endpush
