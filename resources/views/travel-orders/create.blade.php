@extends('layouts.app')

@section('title', 'Create Travel Order')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Create New Travel Order</h1>
        <p class="text-muted">Please fill in all required fields marked with an asterisk (*)</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('travel-orders.store') }}" method="POST" id="travelOrderForm">
        @csrf
        <input type="hidden" name="status_id" value="{{ $status_id ?? '' }}">
            
        <!-- Travel Order Header -->
        <div class="card mb-4">
            <div class="card-header text-black d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#headerCollapse" role="button" aria-expanded="true" aria-controls="headerCollapse">
                <h5 class="mb-0">1. Travel Order Information</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="collapse show" id="headerCollapse">
                <div class="card-body">
                    <div class="row">
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
                </div>
            </div>
        </div>

        <!-- Employee Details Section -->
        <div class="card mb-4" id="employeeDetailsCard">
            <div class="card-header text-black d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#employeeDetailsCollapse" role="button" aria-expanded="true" aria-controls="employeeDetailsCollapse">
                <h5 class="mb-0">2. Employee Details</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="collapse show" id="employeeDetailsCollapse">
                <div class="card-body">
                    @if($isAdmin)
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee *</label>
                            <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                <option value="" disabled selected>Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" 
                                            data-position="{{ $emp->position->name ?? '' }}" 
                                            data-division="{{ $emp->divSecUnit->name ?? '' }}" 
                                            data-salary="{{ $emp->salary ?? 0 }}"
                                            data-fullname="{{ $emp->full_name }}"
                                            data-official-station="{{ $emp->official_station ?? 'Not specified' }}"
                                            data-contact-number="{{ $emp->contact_number ?? '' }}"
                                            data-email="{{ $emp->email ?? '' }}"
                                            {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->full_name }} - {{ $emp->position->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="employee_id" value="{{ $employee->id ?? '' }}">
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <label for="full_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ $isAdmin ? old('full_name') : ($employee->full_name ?? '') }}" required {{ !$isAdmin ? 'readonly' : '' }}>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="position" class="form-label">Position *</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                   id="position" name="position" value="{{ $isAdmin ? old('position') : ($employee->position->name ?? '') }}" required readonly>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="div_sec_unit" class="form-label">Division/Section/Unit *</label>
                            <input type="text" class="form-control @error('div_sec_unit') is-invalid @enderror" 
                                   id="div_sec_unit" name="div_sec_unit" value="{{ $isAdmin ? old('div_sec_unit') : ($employee->divSecUnit->name ?? '') }}" required readonly>
                            @error('div_sec_unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="salary" class="form-label">Salary *</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" 
                                       id="salary" name="salary" value="{{ $isAdmin ? old('salary') : ($employee->position->salary ?? '0.00') }}" required readonly>
                            </div>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Travel Request Details Section -->
        <div class="card mb-4" id="requestDetailsCard">
            <div class="card-header text-black d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#requestDetailsCollapse" role="button" aria-expanded="true" aria-controls="requestDetailsCollapse">
                <h5 class="mb-0">3. Travel Request Details</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="collapse show" id="requestDetailsCollapse">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="region_id" class="form-label">Region *</label>
                            <select class="form-select @error('region_id') is-invalid @enderror" id="region_id" name="region_id" required>
                                <option value="" disabled selected>Select Region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="official_station" class="form-label">Official Station *</label>
                            <select class="form-select @error('official_station') is-invalid @enderror" 
                                    id="official_station" name="official_station" required>
                                <option value="" disabled selected>Select a station</option>
                                <!-- Will be populated by JavaScript -->
                            </select>
                            @error('official_station')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="address" class="form-label">Complete Address *</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="purpose_of_travel" class="form-label">Purpose of Travel *</label>
                            <textarea class="form-control @error('purpose_of_travel') is-invalid @enderror" 
                                      id="purpose_of_travel" name="purpose_of_travel" rows="3" required>{{ old('purpose_of_travel') }}</textarea>
                            @error('purpose_of_travel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Itinerary Section -->
        <div class="card mb-4" id="travelItineraryCard">
            <div class="card-header text-black d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#travelItineraryCollapse" role="button" aria-expanded="true" aria-controls="travelItineraryCollapse">
                <h5 class="mb-0">4. Travel Itinerary</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="collapse show" id="travelItineraryCollapse">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="destination" class="form-label">Destination *</label>
                            <input type="text" class="form-control @error('destination') is-invalid @enderror" 
                                   id="destination" name="destination" value="{{ old('destination') }}" required>
                            @error('destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="departure_date" class="form-label">Departure Date *</label>
                            <input type="date" class="form-control @error('departure_date') is-invalid @enderror" 
                                   id="departure_date" name="departure_date" value="{{ old('departure_date') }}" required>
                            @error('departure_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="arrival_date" class="form-label">Arrival Date *</label>
                            <input type="date" class="form-control @error('arrival_date') is-invalid @enderror" 
                                   id="arrival_date" name="arrival_date" value="{{ old('arrival_date') }}" required>
                            @error('arrival_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="card mb-4" id="additionalInfoCard">
            <div class="card-header text-black d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#additionalInfoCollapse" role="button" aria-expanded="true" aria-controls="additionalInfoCollapse">
                <h5 class="mb-0">5. Additional Information</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="collapse show" id="additionalInfoCollapse">
                <div class="card-body">
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
                            <label for="assistant_or_laborers_allowed" class="form-label">Assistant or Laborers Allowed *</label>
                            <div class="input-group">
                                <input type="number" step="1" class="form-control @error('assistant_or_laborers_allowed') is-invalid @enderror" 
                                       id="assistant_or_laborers_allowed" name="assistant_or_laborers_allowed" value="{{ old('assistant_or_laborers_allowed', 0) }}" required>
                            </div>
                            @error('assistant_or_laborers_allowed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="appropriations" class="form-label">Appropriations *</label>
                            <input type="text" class="form-control @error('appropriations') is-invalid @enderror" 
                                   id="appropriations" name="appropriations" value="{{ old('appropriations') }}" required>
                            @error('appropriations')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signatories Section -->
        <div class="card mb-4" id="signatoriesCard">
            <div class="card-header text-black d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#signatoriesCollapse" role="button" aria-expanded="true" aria-controls="signatoriesCollapse">
                <h5 class="mb-0">6. Signatories</h5>
                <i class="fas fa-chevron-down"></i>
                </div>
                <div class="collapse show" id="signatoriesCollapse">
                    <div class="card-body">
                        @php
                            // Get recommender and approver user type IDs
                            $recommenderType = $userTypes->firstWhere('name', 'Recommender');
                            $approverType = $userTypes->firstWhere('name', 'Approver');
                            
                            $oldSignatories = old('signatories', []);
                            $recommender = $oldSignatories ? collect($oldSignatories)->firstWhere('user_type_id', $recommenderType ? $recommenderType->id : null) : null;
                            $approver = $oldSignatories ? collect($oldSignatories)->firstWhere('user_type_id', $approverType ? $approverType->id : null) : null;
                        @endphp
                        
                        <div class="row mb-3 signatory-row">
                            <!-- Recommender -->
                            <div class="col-md-6">
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
                        
                            <!-- Approver -->
                            <div class="col-md-6">
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

        </div>

        <!-- Form Submission -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('travel-orders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                        <div>
                            <button type="button" id="saveDraftBtn" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-save me-1"></i> Save as Draft
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Submit Travel Order
                            </button>
                        </div>
                    </div>
                </div>
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
        // Handle region selection and load official stations
        const regionSelect = document.getElementById('region_id');
        const officialStationSelect = document.getElementById('official_station');
        const addressInput = document.getElementById('address');
        const contactNumberInput = document.getElementById('contact_number');
        const emailInput = document.getElementById('email');
        
        // Function to load official stations based on selected region
        function loadOfficialStations(regionId) {
            if (!regionId) {
                // Clear and disable the station select if no region is selected
                officialStationSelect.innerHTML = '<option value="" disabled selected>Select a station</option>';
                officialStationSelect.disabled = true;
                return;
            }
            
            // Show loading state
            officialStationSelect.disabled = true;
            officialStationSelect.innerHTML = '<option value="" disabled>Loading stations...</option>';
            
            // Fetch stations for the selected region
            fetch(`/api/regions/${regionId}/stations`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load stations');
                    }
                    return response.json();
                })
                .then(stations => {
                    // Clear previous options
                    officialStationSelect.innerHTML = '<option value="" disabled selected>Select a station</option>';
                    
                    if (stations.length === 0) {
                        const option = document.createElement('option');
                        option.value = "";
                        option.textContent = 'No stations available';
                        officialStationSelect.appendChild(option);
                        officialStationSelect.disabled = true;
                        return;
                    }
                    
                    // Add new options
                    stations.forEach(station => {
                        const option = document.createElement('option');
                        option.value = station.id;
                        option.textContent = station.name;
                        // Store the full station data as a data attribute
                        option.dataset.address = station.address || '';
                        officialStationSelect.appendChild(option);
                    });
                    
                    // Enable the select
                    officialStationSelect.disabled = false;
                    
                    // If there's a previously selected value, try to restore it
                    const oldValue = officialStationSelect.dataset.previousValue;
                    if (oldValue) {
                        const optionExists = Array.from(officialStationSelect.options).some(opt => opt.value === oldValue);
                        if (optionExists) {
                            officialStationSelect.value = oldValue;
                        }
                        delete officialStationSelect.dataset.previousValue;
                    }
                    
                    // Trigger change event to update any dependent fields
                    officialStationSelect.dispatchEvent(new Event('change'));
                })
                .catch(error => {
                    console.error('Error loading stations:', error);
                    officialStationSelect.innerHTML = '<option value="" disabled>Error loading stations. Please try again.</option>';
                    officialStationSelect.disabled = true;
                });
        }
        
        // Handle official station change
        officialStationSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.dataset.address) {
                addressInput.value = selectedOption.dataset.address;
            } else {
                addressInput.value = '';
            }
        });

        // Handle region change
        regionSelect.addEventListener('change', function() {
            const regionId = this.value;
            
            // Store the current station value before changing
            if (officialStationSelect.value) {
                officialStationSelect.dataset.previousValue = officialStationSelect.value;
            }
            
            // Load stations for the selected region
            loadOfficialStations(regionId);
        });
        
        // Initialize stations if a region is already selected
        if (regionSelect.value) {
            loadOfficialStations(regionSelect.value);
        }
        
        if (regionSelect) {
            // Store stations data for the current region
            let currentStations = [];
            
            // Function to load official stations for a region
            async function loadOfficialStations(regionId) {
                const officialStationSelect = document.getElementById('official_station');
                
                try {
                    const response = await fetch(`/api/regions/${regionId}/stations`);
                    currentStations = await response.json();
                    
                    // Clear existing options except the first one
                    while (officialStationSelect.options.length > 1) {
                        officialStationSelect.remove(1);
                    }
                    
                    // Add new station options
                    currentStations.forEach(station => {
                        const option = document.createElement('option');
                        option.value = station.code;
                        option.dataset.address = station.address || '';
                        option.textContent = `${station.code} - ${station.name}`;
                        officialStationSelect.appendChild(option);
                    });
                    
                    // If there's only one station, select it by default
                    if (currentStations.length === 1) {
                        officialStationSelect.value = currentStations[0].code;
                        // Update address when only one station is available
                        updateAddressFromStation(currentStations[0]);
                    }
                    
                    return currentStations;
                } catch (error) {
                    console.error('Error loading official stations:', error);
                    currentStations = [];
                    return [];
                }
            }
            
            // Function to update address based on selected station
            function updateAddressFromStation(station) {
                const addressInput = document.getElementById('address');
                if (station && station.address) {
                    addressInput.value = station.address;
                }
            }
            
            // Handle station selection change
            document.getElementById('official_station').addEventListener('change', function() {
                const selectedStationCode = this.value;
                if (selectedStationCode) {
                    const selectedStation = currentStations.find(s => s.code === selectedStationCode);
                    if (selectedStation) {
                        updateAddressFromStation(selectedStation);
                    }
                } else {
                    document.getElementById('address').value = '';
                }
            });
            
            regionSelect.addEventListener('change', async function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (selectedOption.value) {
                    // Update contact info from region
                    contactNumberInput.value = selectedOption.dataset.contactNumber || '';
                    emailInput.value = selectedOption.dataset.email || '';
                    
                    // Load official stations for the selected region
                    await loadOfficialStations(selectedOption.value);
                } else {
                    // Clear all fields if no region is selected
                    document.getElementById('address').value = '';
                    contactNumberInput.value = '';
                    emailInput.value = '';
                    
                    // Clear station select
                    const officialStationSelect = document.getElementById('official_station');
                    while (officialStationSelect.options.length > 1) {
                        officialStationSelect.remove(1);
                    }
                    officialStationSelect.value = '';
                    
                    // Clear stations data
                    currentStations = [];
                }
            });
        }

        // Auto-fill employee details when selected or on page load for non-admin
        const employeeSelect = document.getElementById('employee_id');
        const fullNameInput = document.getElementById('full_name');
        const positionInput = document.getElementById('position');
        const divisionInput = document.getElementById('div_sec_unit');
        const salaryInput = document.getElementById('salary');
        const officialStationInput = document.getElementById('official_station');
        const dateInput = document.getElementById('date');
        const isAdmin = {{ $isAdmin ? 'true' : 'false' }};

        // Store position salaries for admin users
        const positionSalaries = {};
        @if($isAdmin)
            @foreach($employees as $emp)
                @if($emp->position)
                    positionSalaries['{{ $emp->position->name }}'] = {{ $emp->position->salary ?? '0' }};
                @endif
            @endforeach
        @endif

        // Function to update employee details
        function updateEmployeeDetails() {
            if (isAdmin && employeeSelect) {
                const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
                if (selectedOption.value) {
                    const position = selectedOption.dataset.position || '';
                    fullNameInput.value = selectedOption.dataset.fullname || '';
                    positionInput.value = position;
                    divisionInput.value = selectedOption.dataset.division || '';
                    
                    // Get salary from position data
                    const salary = positionSalaries[position] || 0;
                    salaryInput.value = salary ? parseFloat(salary).toFixed(2) : '0.00';
                    
                    officialStationInput.value = selectedOption.dataset.officialStation || 'Not specified';
                } else {
                    clearEmployeeFields();
                }
            }
            
            // Set current date if not already set
            if (!dateInput.value) {
                const today = new Date();
                dateInput.value = today.toISOString().split('T')[0];
            }
        }

        function clearEmployeeFields() {
            fullNameInput.value = '';
            positionInput.value = '';
            divisionInput.value = '';
            salaryInput.value = '0.00';
            officialStationInput.value = '';
        }

        // For non-admin users, the fields are pre-filled from the server
        // For admins, set up the change event listener
        if (isAdmin && employeeSelect) {
            employeeSelect.addEventListener('change', updateEmployeeDetails);
            
            // Trigger change event if there's a selected value (for form validation errors)
            if (employeeSelect.value) {
                updateEmployeeDetails();
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
