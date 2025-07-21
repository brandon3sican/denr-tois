@extends('layouts.app')

@section('title', 'Create Travel Order')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Create New Travel Order</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('travel-orders.store') }}" method="POST" id="travelOrderForm">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="travel_order_no" class="form-label">Travel Order No. *</label>
                    <input type="text" class="form-control @error('travel_order_no') is-invalid @enderror" 
                           id="travel_order_no" name="travel_order_no" value="{{ old('travel_order_no', 'TO-' . date('Ymd') . '-' . strtoupper(Str::random(4))) }}" required>
                    @error('travel_order_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label">Date *</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                           id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee *</label>
                <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                    <option value="" disabled selected>Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" data-position="{{ $employee->position->name ?? '' }}" 
                                data-division="{{ $employee->divSecUnit->name ?? '' }}" data-salary="{{ $employee->salary ?? 0 }}"
                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="position" class="form-label">Position *</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                           id="position" name="position" value="{{ old('position') }}" required readonly>
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="div_sec_unit" class="form-label">Division/Section/Unit *</label>
                    <input type="text" class="form-control @error('div_sec_unit') is-invalid @enderror" 
                           id="div_sec_unit" name="div_sec_unit" value="{{ old('div_sec_unit') }}" required readonly>
                    @error('div_sec_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="salary" class="form-label">Salary *</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" 
                               id="salary" name="salary" value="{{ old('salary') }}" required readonly>
                    </div>
                    @error('salary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="departure_date" class="form-label">Departure Date *</label>
                    <input type="date" class="form-control @error('departure_date') is-invalid @enderror" 
                           id="departure_date" name="departure_date" value="{{ old('departure_date') }}" required>
                    @error('departure_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="arrival_date" class="form-label">Arrival Date *</label>
                    <input type="date" class="form-control @error('arrival_date') is-invalid @enderror" 
                           id="arrival_date" name="arrival_date" value="{{ old('arrival_date') }}" required>
                    @error('arrival_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="official_station" class="form-label">Official Station *</label>
                    <input type="text" class="form-control @error('official_station') is-invalid @enderror" 
                           id="official_station" name="official_station" value="{{ old('official_station') }}" required>
                    @error('official_station')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="destination" class="form-label">Destination *</label>
                    <input type="text" class="form-control @error('destination') is-invalid @enderror" 
                           id="destination" name="destination" value="{{ old('destination') }}" required>
                    @error('destination')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="purpose_of_travel" class="form-label">Purpose of Travel *</label>
                <textarea class="form-control @error('purpose_of_travel') is-invalid @enderror" 
                          id="purpose_of_travel" name="purpose_of_travel" rows="3" required>{{ old('purpose_of_travel') }}</textarea>
                @error('purpose_of_travel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="per_diem_expenses" class="form-label">Per Diem Expenses (₱) *</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" class="form-control @error('per_diem_expenses') is-invalid @enderror" 
                               id="per_diem_expenses" name="per_diem_expenses" value="{{ old('per_diem_expenses', 0) }}" required>
                    </div>
                    @error('per_diem_expenses')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-4 pt-3">
                        <input class="form-check-input @error('assistant_or_laborers_allowed') is-invalid @enderror" 
                               type="checkbox" id="assistant_or_laborers_allowed" name="assistant_or_laborers_allowed" 
                               value="1" {{ old('assistant_or_laborers_allowed') ? 'checked' : '' }}>
                        <label class="form-check-label" for="assistant_or_laborers_allowed">
                            Assistant or Laborers Allowed
                        </label>
                        @error('assistant_or_laborers_allowed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="status_id" class="form-label">Status *</label>
                    <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                        <option value="" disabled selected>Select Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="appropriations" class="form-label">Appropriations</label>
                <input type="text" class="form-control @error('appropriations') is-invalid @enderror" 
                       id="appropriations" name="appropriations" value="{{ old('appropriations') }}">
                @error('appropriations')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                          id="remarks" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                @error('remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Signatories</h6>
                </div>
                <div class="card-body">
                    <div id="signatories-container">
                        @php
                            // Get recommender and approver user type IDs
                            $recommenderType = $userTypes->firstWhere('name', 'Recommender');
                            $approverType = $userTypes->firstWhere('name', 'Approver');
                            
                            $oldSignatories = old('signatories', []);
                            $recommender = $oldSignatories ? collect($oldSignatories)->firstWhere('user_type_id', $recommenderType ? $recommenderType->id : null) : null;
                            $approver = $oldSignatories ? collect($oldSignatories)->firstWhere('user_type_id', $approverType ? $approverType->id : null) : null;
                        @endphp
                        
                        <!-- Recommender -->
                        <div class="row mb-3 signatory-row">
                            <div class="col-md-10">
                                <label class="form-label">Recommender *</label>
                                <select class="form-select signatory-employee" name="signatories[0][employee_id]" required data-role="recommender">
                                    <option value="" disabled selected>Select Recommender</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" 
                                            {{ ($recommender && $recommender['employee_id'] == $employee->id) ? 'selected' : '' }}
                                            data-fullname="{{ $employee->full_name }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="signatories[0][user_type_id]" value="{{ $recommenderType ? $recommenderType->id : '' }}">
                            </div>
                        </div>
                        
                        <!-- Approver -->
                        <div class="row mb-3 signatory-row">
                            <div class="col-md-10">
                                <label class="form-label">Approver *</label>
                                <select class="form-select signatory-employee" name="signatories[1][employee_id]" required data-role="approver">
                                    <option value="" disabled selected>Select Approver</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ ($approver && $approver['employee_id'] == $employee->id) ? 'selected' : '' }}
                                            data-fullname="{{ $employee->full_name }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="signatories[1][user_type_id]" value="{{ $approverType ? $approverType->id : '' }}">
                            </div>
                        </div>
                        
                        <div id="signatory-error" class="text-danger mb-3" style="display: none;">
                            Recommender and Approver must be different people.
                        </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('travel-orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Travel Order
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .signatory-row {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-fill employee details when selected
        const employeeSelect = document.getElementById('employee_id');
        const fullNameInput = document.getElementById('full_name');
        const positionInput = document.getElementById('position');
        const divisionInput = document.getElementById('div_sec_unit');
        const salaryInput = document.getElementById('salary');

        if (employeeSelect) {
            employeeSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    positionInput.value = selectedOption.dataset.position;
                    divisionInput.value = selectedOption.dataset.division;
                    salaryInput.value = selectedOption.dataset.salary || '0.00';
                } else {
                    positionInput.value = '';
                    divisionInput.value = '';
                    salaryInput.value = '0.00';
                }
            });

            // Trigger change event if there's a selected value (for form validation errors)
            if (employeeSelect.value) {
                employeeSelect.dispatchEvent(new Event('change'));
            }
        }

        // Get recommender and approver selects
        const recommenderSelect = document.querySelector('select[data-role="recommender"]');
        const approverSelect = document.querySelector('select[data-role="approver"]');
        const signatoryError = document.getElementById('signatory-error');

        // Function to validate signatories
        function validateSignatories() {
            if (!recommenderSelect || !approverSelect) return true;
            
            const recommenderId = recommenderSelect.value;
            const approverId = approverSelect.value;
            
            if (recommenderId && approverId && recommenderId === approverId) {
                signatoryError.style.display = 'block';
                return false;
            } else {
                signatoryError.style.display = 'none';
                return true;
            }
        }

        // Add validation on change
        if (recommenderSelect && approverSelect) {
            recommenderSelect.addEventListener('change', validateSignatories);
            approverSelect.addEventListener('change', validateSignatories);
        }

        // Form validation
        const form = document.getElementById('travelOrderForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Validate signatories
                if (!validateSignatories()) {
                    e.preventDefault();
                    signatoryError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }

                // Check if all required fields are filled
                let isValid = true;
                form.querySelectorAll('[required]').forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return false;
                }

                // Check if departure date is before arrival date
                const departureDate = new Date(document.getElementById('departure_date').value);
                const arrivalDate = new Date(document.getElementById('arrival_date').value);
                
                if (departureDate > arrivalDate) {
                    e.preventDefault();
                    alert('Departure date must be before or equal to arrival date.');
                    return false;
                }

                return true;
            });
        }
    });
</script>
@endpush
@endsection
