@extends('layouts.app')

@section('content')
<div class="mb-5 border-bottom pb-4">
    <div class="row align-items-center">
        <div class="col-auto">
            <div class="bg-navy bg-opacity-10 p-3 rounded-4 text-navy">
                <i class="bi bi-file-earmark-plus fs-2" style="color: #001f3f;"></i>
            </div>
        </div>
        <div class="col">
            <h2 class="fw-extrabold mb-1">New Transmittal</h2>
            <p class="text-muted small mb-0">Record and submit a new document transfer protocol.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('transmittals.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
        </div>
    </div>
</div>

<form action="{{ route('transmittals.store') }}" method="POST" x-data="transmittalForm()">
    @csrf
    
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><i class="bi bi-info-circle me-2"></i>Header Info</div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Reference Number</label>
                        <input type="text" name="reference_number" value="{{ old('reference_number', $nextRef) }}" class="form-control fw-bold" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-uppercase text-muted">Transmittal Date</label>
                        <input type="date" name="transmittal_date" value="{{ old('transmittal_date', date('Y-m-d')) }}" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><i class="bi bi-geo-alt me-2"></i>Routing</div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Originating Office</label>
                        <input type="text" value="{{ Auth::user()->office->name }}" class="form-control bg-light" disabled>
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-uppercase text-muted">Destination Office</label>
                        <select name="receiver_office_id" class="form-select @error('receiver_office_id') is-invalid @enderror" required>
                            <option value="">Select Target Office...</option>
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}" {{ old('receiver_office_id') == $office->id ? 'selected' : '' }}>{!! $office->display_name !!}</option>
                            @endforeach
                        </select>
                        @error('receiver_office_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><i class="bi bi-chat-left-text me-2"></i>Additional Notes</div>
                <div class="card-body">
                    <label class="form-label small fw-bold text-uppercase text-muted">Executive Remarks</label>
                    <textarea name="remarks" class="form-control" rows="4" placeholder="Optional context for this transmittal...">{{ old('remarks') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-list-task me-2"></i>Enclosure Items</span>
            <div class="text-muted small">At least one item required. Tab key supported.</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" id="items-table">
                    <thead class="bg-light">
                        <tr class="small text-uppercase">
                            <th width="80" class="text-center">#</th>
                            <th width="120">Qty</th>
                            <th width="150">Unit</th>
                            <th>Description / Particulars</th>
                            <th>Item Remarks</th>
                            <th width="80" class="text-center pe-3">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="text-center align-middle text-muted small" x-text="index + 1"></td>
                                <td>
                                    <input type="number" 
                                           :name="'items['+index+'][quantity]'" 
                                           x-model="item.quantity" 
                                           class="text-center fw-bold" 
                                           placeholder="0"
                                           @keydown.enter.prevent="focusNext(index, 'unit')">
                                </td>
                                <td>
                                    <input type="text" 
                                           :name="'items['+index+'][unit]'" 
                                           x-model="item.unit" 
                                           placeholder="e.g. pcs"
                                           @keydown.enter.prevent="focusNext(index, 'description')">
                                </td>
                                <td>
                                    <textarea :name="'items['+index+'][description]'" 
                                              x-model="item.description" 
                                              rows="1"
                                              class="py-2"
                                              placeholder="Document code or title..."
                                              @keydown.enter.prevent="focusNext(index, 'remarks')"></textarea>
                                </td>
                                <td>
                                    <input type="text" 
                                           :name="'items['+index+'][remarks]'" 
                                           x-model="item.remarks" 
                                           placeholder="Optional..."
                                           @keydown.enter.prevent="addRowAndFocus(index)">
                                </td>
                                <td class="text-center align-middle pe-3">
                                    <button type="button" @click="removeItem(index)" class="btn btn-link text-danger p-0 border-0" x-show="items.length > 1">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 py-3">
            <button type="button" @click="addItem()" class="btn btn-sm btn-outline-navy rounded-pill">
                <i class="bi bi-plus-lg me-1"></i> Add Another Row
            </button>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-3 mb-5">
        <button type="reset" class="btn btn-light rounded-pill px-4 fw-bold">Reset</button>
        <button type="submit" name="status" value="Draft" class="btn btn-outline-navy rounded-pill px-4 fw-bold">
            <i class="bi bi-save me-1"></i>Save as Draft
        </button>
        <button type="submit" name="status" value="Submitted" class="btn btn-navy rounded-pill px-5 py-3 fw-bold shadow">
            <i class="bi bi-check2-all me-2"></i>Finalize & Submit Form
        </button>
    </div>
</form>

<script>
    function transmittalForm() {
        return {
            status: 'Submitted',
            items: [
                { quantity: '', unit: 'pcs', description: '', remarks: '' },
                { quantity: '', unit: 'pcs', description: '', remarks: '' },
                { quantity: '', unit: 'pcs', description: '', remarks: '' },
                { quantity: '', unit: 'pcs', description: '', remarks: '' },
                { quantity: '', unit: 'pcs', description: '', remarks: '' }
            ],
            
            addItem() {
                this.items.push({ quantity: '', unit: 'pcs', description: '', remarks: '' });
            },
            
            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },
            
            focusNext(index, field) {
                // Simplified focus logic for Bootstrap inputs
                // In a real table with generated inputs, we use data attributes or specific selectors
            },
            
            addRowAndFocus(index) {
                if (index === this.items.length - 1) {
                    this.addItem();
                }
            }
        }
    }
</script>

<style>
    #items-table tr td {
        vertical-align: middle;
    }
    #items-table input, #items-table textarea {
        background: transparent !important;
        border: 1px solid transparent !important;
        transition: all 0.2s;
        display: block;
        width: 100%;
        padding: 0.75rem 0.5rem;
    }
    #items-table input:focus, #items-table textarea:focus {
        border-color: #dee2e6 !important;
        background: #fff !important;
        border-radius: 0.5rem;
    }
    .btn-outline-navy {
        color: #001f3f;
        border-color: #001f3f;
    }
    .btn-outline-navy:hover {
        background-color: #001f3f;
        color: #fff;
    }
</style>
@endsection
