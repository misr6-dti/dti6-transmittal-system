@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <nav aria-label="breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li class="text-navy hover:text-navy-light"><a href="{{ route('admin.offices.index') }}" class="text-navy">Office Management</a></li>
            <li class="text-slate-500">Edit Office</li>
        </ol>
    </nav>
    <h2 class="text-2xl font-extrabold text-navy">Edit Office Details</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="p-6 md:p-10">
                <form action="{{ route('admin.offices.update', $office) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Office Name</label>
                        <input type="text" name="name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('name') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" value="{{ old('name', $office->name) }}" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Office Type</label>
                            <select name="type" id="officeType" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all appearance-none @error('type') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" required>
                                <option value="">Select Office Type</option>
                                <option value="Regional" {{ old('type', $office->type) == 'Regional' ? 'selected' : '' }}>Regional Office</option>
                                <option value="Provincial" {{ old('type', $office->type) == 'Provincial' ? 'selected' : '' }}>Provincial Office</option>
                                <option value="Satellite" {{ old('type', $office->type) == 'Satellite' ? 'selected' : '' }}>Satellite Office</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Office Code</label>
                            <input type="text" name="code" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('code') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" value="{{ old('code', $office->code) }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Parent Office (Optional)</label>
                        <select name="parent_id" id="parentOffice" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all appearance-none @error('parent_id') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror">
                            <option value="">No Parent - This is a Root Office</option>
                        </select>
                        <small class="text-slate-500 block mt-2">Parent office options will be filtered based on the selected office type hierarchy.</small>
                    </div>

                    <div class="flex justify-end gap-2 mt-5">
                        <a href="{{ route('admin.offices.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-50 transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Update Office
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
    const currentOfficeId = {{ $office->id }};
    const currentParentId = '{{ old('parent_id', $office->parent_id) }}';
    
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
                (office.type === 'Regional' || office.type === 'Provincial') && 
                office.id !== currentOfficeId
            );
        } else {
            validParents = allOffices.filter(office => 
                allowedParentTypes.includes(office.type) && 
                office.parent_id === null && 
                office.id !== currentOfficeId
            );
        }
        
        // Sort by name and add to dropdown
        validParents.sort((a, b) => a.name.localeCompare(b.name)).forEach(office => {
            const option = document.createElement('option');
            option.value = office.id;
            option.textContent = office.name + ' (' + office.type + ')';
            
            // Preserve selection
            if (currentParentId == office.id) {
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
