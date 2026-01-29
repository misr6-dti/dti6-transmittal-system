@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.offices.index') }}" class="text-navy">Office Management</a></li>
            <li class="breadcrumb-item active">New Office</li>
        </ol>
    </nav>
    <h2 class="fw-extrabold mb-0">Create New Office</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.offices.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Office Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. DTI Region VI RO" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Office Type</label>
                            <select name="type" id="officeType" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Office Type</option>
                                <option value="Regional" {{ old('type') == 'Regional' ? 'selected' : '' }}>Regional Office</option>
                                <option value="Provincial" {{ old('type') == 'Provincial' ? 'selected' : '' }}>Provincial Office</option>
                                <option value="Satellite" {{ old('type') == 'Satellite' ? 'selected' : '' }}>Satellite Office</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Office Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="e.g. RO6" required>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Parent Office (Optional)</label>
                        <select name="parent_id" id="parentOffice" class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">No Parent - This is a Root Office</option>
                        </select>
                        <small class="text-muted d-block mt-2">Parent office options will be filtered based on the selected office type hierarchy.</small>
                        @error('parent_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('admin.offices.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-navy px-5">
                            <i class="bi bi-building-plus me-2"></i>Create Office
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('officeType');
    const parentSelect = document.getElementById('parentOffice');
    
    // Store all offices data
    const allOffices = @json(\App\Models\Office::with('children')->get());
    
    // Office type hierarchy - what parent types are allowed for each type
    const typeHierarchy = {
        'Regional': [],  // Regional can only be root
        'Provincial': ['Regional'],  // Provincial can be under Regional
        'Satellite': ['Regional', 'Provincial'],  // Satellite can be under Regional or Provincial
    };
    
    function updateParentOptions() {
        const selectedType = typeSelect.value;
        const allowedParentTypes = typeHierarchy[selectedType] || [];
        
        // Clear all options except the "No Parent" option
        parentSelect.innerHTML = '<option value="">No Parent - This is a Root Office</option>';
        
        if (allowedParentTypes.length === 0) {
            parentSelect.disabled = true;
            return;
        }
        
        parentSelect.disabled = false;
        
        // For Satellite Office, show all regional and provincial offices
        // Otherwise, show only root offices of allowed parent types
        let validParents;
        if (selectedType === 'Satellite') {
            validParents = allOffices.filter(office => 
                (office.type === 'Regional' || office.type === 'Provincial')
            );
        } else {
            validParents = allOffices.filter(office => 
                allowedParentTypes.includes(office.type) && office.parent_id === null
            );
        }
        
        // Sort by name and add to dropdown
        validParents.sort((a, b) => a.name.localeCompare(b.name)).forEach(office => {
            const option = document.createElement('option');
            option.value = office.id;
            option.textContent = office.name + ' (' + office.type + ')';
            
            // Preserve selection if this was previously selected
            if ('{{ old('parent_id') }}' == office.id) {
                option.selected = true;
            }
            
            parentSelect.appendChild(option);
        });
    }
    
    // Update on type change
    typeSelect.addEventListener('change', updateParentOptions);
    
    // Initial population on page load
    updateParentOptions();
});
</script>
@endsection
