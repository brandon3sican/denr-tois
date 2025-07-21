@extends('layouts.app')

@section('title', 'Edit Travel Order')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Edit Travel Order: {{ $travelOrder->travel_order_no }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('travel-orders.update', $travelOrder) }}" method="POST" id="travelOrderForm">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="travel_order_no" class="form-label">Travel Order No. *</label>
                    <input type="text" class="form-control @error('travel_order_no') is-invalid @enderror" 
                           id="travel_order_no" name="travel_order_no" value="{{ old('travel_order_no', $travelOrder->travel_order_no) }}" required>
                    @error('travel_order_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label">Date *</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                           id="date" name="date" value="{{ old('date', $travelOrder->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee *</label>
                <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                    <option value="" disabled>Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" data-position="{{ $employee->position->name ?? '' }}" 
                                data-division="{{ $employee->divSecUnit->name ?? '' }}" data-salary="{{ $employee->salary ?? 0 }}"
                                {{ old('employee_id', $travelOrder->employee_id) == $employee->id ? 'selected' : '' }}>
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
                           id="position" name="position" value="{{ old('position', $travelOrder->position) }}" required readonly>
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="div_sec_unit" class="form-label">Division/Section/Unit *</label>
                    <input type="text" class="form-control @error('div_sec_unit') is-invalid @enderror" 
                           id="div_sec_unit" name="div_sec_unit" value="{{ old('div_sec_unit', $travelOrder->div_sec_unit) }}" required readonly>
                    @error('div_sec_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="salary" class="form-label">Salary *</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" 
                               id="salary" name="salary" value="{{ old('salary', $travelOrder->salary) }}" required readonly>
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
                           id="departure_date" name="departure_date" 
                           value="{{ old('departure_date', $travelOrder->departure_date->format('Y-m-d')) }}" required>
                    @error('departure_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="arrival_date" class="form-label">Arrival Date *</label>
                    <input type="date" class="form-control @error('arrival_date') is-invalid @enderror" 
                           id="arrival_date" name="arrival_date" 
                           value="{{ old('arrival_date', $travelOrder->arrival_date->format('Y-m-d')) }}" required>
                    @error('arrival_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="official_station" class="form-label">Official Station *</label>
                    <input type="text" class="form-control @error('official_station') is-invalid @enderror" 
                           id="official_station" name="official_station" 
                           value="{{ old('official_station', $travelOrder->official_station) }}" required>
                    @error('official_station')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="region_id" class="form-label">Region *</label>
                    <select class="form-select @error('region_id') is-invalid @enderror" id="region_id" name="region_id" required>
                        <option value="" disabled>Select Region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" 
                                    data-address="{{ $region->address }}"
                                    data-contact-number="{{ $region->contact_number }}"
                                    data-email="{{ $region->email }}"
                                    {{ old('region_id', $travelOrder->region_id) == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('region_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="address" class="form-label">Complete Address *</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                           id="address" name="address" value="{{ old('address', $travelOrder->address) }}" required>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="destination" class="form-label">Destination *</label>
                    <input type="text" class="form-control @error('destination') is-invalid @enderror" 
                           id="destination" name="destination" value="{{ old('destination', $travelOrder->destination) }}" required>
                    @error('destination')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="purpose_of_travel" class="form-label">Purpose of Travel *</label>
                <textarea class="form-control @error('purpose_of_travel') is-invalid @enderror" 
                          id="purpose_of_travel" name="purpose_of_travel" rows="3" required>{{ old('purpose_of_travel', $travelOrder->purpose_of_travel) }}</textarea>
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
                               id="per_diem_expenses" name="per_diem_expenses" 
                               value="{{ old('per_diem_expenses', $travelOrder->per_diem_expenses) }}" required>
                    </div>
                    @error('per_diem_expenses')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-4 pt-3">
                        <input class="form-check-input @error('assistant_or_laborers_allowed') is-invalid @enderror" 
                               type="checkbox" id="assistant_or_laborers_allowed" name="assistant_or_laborers_allowed" 
                               value="1" {{ old('assistant_or_laborers_allowed', $travelOrder->assistant_or_laborers_allowed) ? 'checked' : '' }}>
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
                        <option value="" disabled>Select Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id', $travelOrder->status_id) == $status->id ? 'selected' : '' }}>
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
                       id="appropriations" name="appropriations" 
                       value="{{ old('appropriations', $travelOrder->appropriations) }}">
                @error('appropriations')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                          id="remarks" name="remarks" rows="2">{{ old('remarks', $travelOrder->remarks) }}</textarea>
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
                            $oldSignatories = old('signatories', $travelOrder->signatories->map(function($signatory) {
                                return [
                                    'employee_id' => $signatory->employee_id,
                                    'user_type_id' => $signatory->user_type_id
                                ];
                            })->toArray());
                        @endphp

                        @foreach($oldSignatories as $index => $signatory)
                            <div class="row mb-3 signatory-row">
                                <div class="col-md-5">
                                    <label class="form-label">Employee *</label>
                                    <select class="form-select signatory-employee" 
                                            name="signatories[{{ $index }}][employee_id]" required>
                                        <option value="" disabled>Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" 
                                                {{ (isset($signatory['employee_id']) && $signatory['employee_id'] == $employee->id) ? 'selected' : '' }}>
                                                {{ $employee->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Role *</label>
                                    <select class="form-select" name="signatories[{{ $index }}][user_type_id]" required>
                                        <option value="" disabled>Select Role</option>
                                        @foreach($userTypes as $type)
                                            <option value="{{ $type->id }}" 
                                                {{ (isset($signatory['user_type_id']) && $signatory['user_type_id'] == $type->id) ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-signatory" style="margin-bottom: 1rem;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" id="add-signatory" class="btn btn-sm btn-secondary mt-2">
                        <i class="fas fa-plus"></i> Add Signatory
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('travel-orders.show', $travelOrder) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Travel Order
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
        // Handle region selection
        const regionSelect = document.getElementById('region_id');
        const addressInput = document.getElementById('address');
        const contactNumberInput = document.getElementById('contact_number');
        const emailInput = document.getElementById('email');
        
        if (regionSelect) {
            // Set initial values if editing
            if (regionSelect.value) {
                const selectedOption = regionSelect.options[regionSelect.selectedIndex];
                if (selectedOption) {
                    addressInput.value = selectedOption.dataset.address || '';
                    contactNumberInput.value = selectedOption.dataset.contactNumber || '{{ old('contact_number', $travelOrder->contact_number) }}';
                    emailInput.value = selectedOption.dataset.email || '{{ old('email', $travelOrder->email) }}';
                }
            }
            
            regionSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    addressInput.value = selectedOption.dataset.address || '';
                    contactNumberInput.value = selectedOption.dataset.contactNumber || '';
                    emailInput.value = selectedOption.dataset.email || '';
                } else {
                    addressInput.value = '';
                    contactNumberInput.value = '';
                    emailInput.value = '';
                }
            });
        }

        // Auto-fill employee details when selected
        const employeeSelect = document.getElementById('employee_id');
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

            // Trigger change event to set initial values
            employeeSelect.dispatchEvent(new Event('change'));
        }

        // Add signatory row
        const addSignatoryBtn = document.getElementById('add-signatory');
        const signatoriesContainer = document.getElementById('signatories-container');
        let signatoryCount = {{ count(old('signatories', $travelOrder->signatories)) }};

        if (addSignatoryBtn) {
            addSignatoryBtn.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'row mb-3 signatory-row';
                newRow.innerHTML = `
                    <div class="col-md-5">
                        <label class="form-label">Employee *</label>
                        <select class="form-select signatory-employee" name="signatories[${signatoryCount}][employee_id]" required>
                            <option value="" disabled selected>Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Role *</label>
                        <select class="form-select" name="signatories[${signatoryCount}][user_type_id]" required>
                            <option value="" disabled selected>Select Role</option>
                            @foreach($userTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-signatory" style="margin-bottom: 1rem;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                signatoriesContainer.appendChild(newRow);
                signatoryCount++;
            });
        }

        // Remove signatory row
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-signatory')) {
                const row = e.target.closest('.signatory-row');
                if (document.querySelectorAll('.signatory-row').length > 1) {
                    row.remove();
                    // Reindex the signatories
                    const rows = document.querySelectorAll('.signatory-row');
                    rows.forEach((row, index) => {
                        row.querySelectorAll('select, input').forEach(input => {
                            input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                        });
                    });
                    signatoryCount = rows.length;
                } else {
                    alert('At least one signatory is required.');
                }
            }
        });

        // Form validation
        const form = document.getElementById('travelOrderForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Check if at least one signatory is added
                const signatoryRows = document.querySelectorAll('.signatory-row');
                if (signatoryRows.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one signatory.');
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
