@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold">
            <i class="fas fa-user-plus mr-2"></i> Create New Employee
        </h5>
        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.store') }}" method="POST" id="employeeForm">
            @csrf
            
            <!-- Personal Information Section -->
            <div class="form-section mt-4">
                <h6><i class="fas fa-user-circle"></i> Personal Information</h6>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="first_name" class="form-label required-field">First Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name') }}" 
                                   placeholder="Enter first name" required>
                        </div>
                        @error('first_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                   id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                                   placeholder="Enter middle name">
                        </div>
                        @error('middle_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="last_name" class="form-label required-field">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                   placeholder="Enter last name" required>
                        </div>
                        @error('last_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="suffix" class="form-label">Suffix</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('suffix') is-invalid @enderror" 
                                   id="suffix" name="suffix" value="{{ old('suffix') }}" 
                                   placeholder="Enter suffix">
                        </div>
                        @error('suffix')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mt-2">
                    <div class="col-md-2 mb-3">
                        <label for="gender" class="form-label required-field">Gender</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        @error('gender')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="birthdate" class="form-label required-field">Birthdate</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" 
                                   id="birthdate" name="birthdate" value="{{ old('birthdate') }}" 
                                   max="{{ now()->subYears(18)->format('Y-m-d') }}" required>
                        </div>
                        <small class="form-text text-muted">Must be at least 18 years old</small>
                        @error('birthdate')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="age" class="form-label">Age</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                            <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                   id="age" name="age" value="{{ old('age') }}" readonly>
                        </div>
                        @error('age')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="date_hired" class="form-label required-field">Date Hired</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                            <input type="date" class="form-control @error('date_hired') is-invalid @enderror" 
                                   id="date_hired" name="date_hired" value="{{ old('date_hired') ?? now()->format('Y-m-d') }}" 
                                   max="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        @error('date_hired')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label required-field">Complete Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="2" 
                                  placeholder="House/Unit No., Street, Barangay, City/Municipality, Province" 
                                  required>{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            
            </div>
            
            <!-- Contact & Employment Information Section -->
            <div class="form-section mt-4">
                <h6><i class="fas fa-id-card"></i> Contact & Employment Information</h6>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="contact_num" class="form-label required-field">Contact Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" class="form-control @error('contact_num') is-invalid @enderror" 
                                   id="contact_num" name="contact_num" value="{{ old('contact_num') }}" 
                                   placeholder="e.g. 09123456789" required>
                        </div>
                        @error('contact_num')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="col-md-3 mb-3">
                        <label for="position_id" class="form-label required-field">Position</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                            <select class="form-select select2 @error('position_id') is-invalid @enderror" 
                                    id="position_id" name="position_id" required>
                                <option value="" disabled selected>Select Position</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('position_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="employment_status_id" class="form-label required-field">Employment Status</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-clipboard-check"></i></span>
                            <select class="form-select select2 @error('employment_status_id') is-invalid @enderror" 
                                    id="employment_status_id" name="employment_status_id" required>
                                <option value="" disabled selected>Select Employment Status</option>
                                @foreach($employmentStatuses as $status)
                                    <option value="{{ $status->id }}" {{ old('employment_status_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('employment_status_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="div_sec_unit_id" class="form-label required-field">Division/Section/Unit</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                            <select class="form-select select2 @error('div_sec_unit_id') is-invalid @enderror" 
                                    id="div_sec_unit_id" name="div_sec_unit_id" required>
                                <option value="" disabled selected>Select Division/Section/Unit</option>
                                @foreach($divSecUnits as $unit)
                                    <option value="{{ $unit->id }}" {{ old('div_sec_unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('div_sec_unit_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-times-circle mr-1"></i> Cancel
                </a>
                <div>
                    <button type="reset" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Save Employee
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for better dropdowns
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });
        }

        // Calculate age based on birthdate
        const birthdateInput = document.getElementById('birthdate');
        const ageInput = document.getElementById('age');
        
        function calculateAge(birthdate) {
            const today = new Date();
            const birthDate = new Date(birthdate);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            return age;
        }

        if (birthdateInput && ageInput) {
            // Initial calculation if birthdate is already set
            if (birthdateInput.value) {
                ageInput.value = calculateAge(birthdateInput.value);
            }

            // Recalculate when birthdate changes
            birthdateInput.addEventListener('change', function() {
                ageInput.value = calculateAge(this.value);
            });
        }

        // Phone number formatting
        const phoneInput = document.getElementById('contact_num');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('63')) {
                    value = '0' + value.substring(2);
                } else if (value.startsWith('+63')) {
                    value = '0' + value.substring(3);
                }
                e.target.value = value;
            });
        }

        // Form validation
        const form = document.getElementById('employeeForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Add any additional client-side validation here
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first invalid field
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }
    });
</script>
@endpush
