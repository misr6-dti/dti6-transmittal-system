@extends('layouts.app')

@section('content')
    <div class="mb-5 border-bottom pb-4">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="bg-warning bg-opacity-10 p-3 rounded-4 text-warning">
                    <i class="bi bi-pencil-square fs-2"></i>
                </div>
            </div>
            <div class="col">
                <h2 class="fw-extrabold mb-1">Update Transmittal Form</h2>
                <p class="text-muted small mb-0">Modifying record #{{ $transmittal->reference_number }} for re-submission.
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ route('transmittals.show', $transmittal) }}" class="btn btn-light rounded-pill px-4">Cancel
                    Edits</a>
            </div>
        </div>
    </div>

    <form action="{{ route('transmittals.update', $transmittal) }}" method="POST" x-data="transmittalForm()">
        @csrf
        @method('PUT')

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header"><i class="bi bi-info-circle me-2"></i>Header Info</div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Reference Number</label>
                            <input type="text" name="reference_number"
                                value="{{ old('reference_number', $transmittal->reference_number) }}"
                                class="form-control fw-bold" required>
                        </div>
                        <div>
                            <label class="form-label small fw-bold text-uppercase text-muted">Transmittal Date</label>
                            <input type="date" name="transmittal_date"
                                value="{{ old('transmittal_date', $transmittal->transmittal_date ? $transmittal->transmittal_date->format('Y-m-d') : '') }}"
                                class="form-control" required>
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
                            <input type="text" value="{{ $transmittal->senderOffice->name }}" class="form-control bg-light"
                                disabled>
                        </div>
                        <div>
                            <label class="form-label small fw-bold text-uppercase text-muted">Destination Office</label>
                            <select name="receiver_office_id"
                                class="form-select @error('receiver_office_id') is-invalid @enderror" required>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}" {{ old('receiver_office_id', $transmittal->receiver_office_id) == $office->id ? 'selected' : '' }}>{{ $office->name }}
                                    </option>
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
                        <textarea name="remarks" class="form-control" rows="4"
                            placeholder="Optional context...">{{ old('remarks', $transmittal->remarks) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-list-task me-2"></i>Enclosure Items</span>
                <div class="text-muted small">At least one item required.</div>
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
                                        <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity"
                                            class="text-center fw-bold" placeholder="0">
                                    </td>
                                    <td>
                                        <input type="text" :name="'items['+index+'][unit]'" x-model="item.unit"
                                            placeholder="pcs">
                                    </td>
                                    <td>
                                        <textarea :name="'items['+index+'][description]'" x-model="item.description"
                                            rows="1" class="py-2" placeholder="Document code..."></textarea>
                                    </td>
                                    <td>
                                        <input type="text" :name="'items['+index+'][remarks]'" x-model="item.remarks"
                                            placeholder="Optional...">
                                    </td>
                                    <td class="text-center align-middle pe-3">
                                        <button type="button" @click="removeItem(index)"
                                            class="btn btn-link text-danger p-0 border-0" x-show="items.length > 1">
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
            <a href="{{ route('transmittals.show', $transmittal) }}"
                class="btn btn-light rounded-pill px-4 fw-bold d-flex align-items-center">Discard Changes</a>
            @if($transmittal->status === 'Draft')
                <button type="submit" name="status" value="Draft" class="btn btn-outline-navy rounded-pill px-4 fw-bold">
                    <i class="bi bi-save me-1"></i>Keep as Draft
                </button>
                <button type="submit" name="status" value="Submitted"
                    class="btn btn-navy rounded-pill px-5 py-3 fw-bold shadow">
                    <i class="bi bi-check2-all me-2"></i>Finalize & Submit Form
                </button>
            @else
                <button type="submit" name="status" value="Submitted"
                    class="btn btn-navy rounded-pill px-5 py-3 fw-bold shadow">
                    <i class="bi bi-save me-2"></i>Update Transmittal Form
                </button>
            @endif
        </div>
    </form>

    <script>
        function transmittalForm() {
            return {
                status: @js($transmittal->status),
                items: @js($transmittal->items->map(fn($item) => [
                    'quantity' => $item->quantity,
                    'unit' => $item->unit,
                    'description' => $item->description,
                    'remarks' => $item->remarks
                ])),

                addItem() {
                    this.items.push({ quantity: '', unit: 'pcs', description: '', remarks: '' });
                },

                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                }
            }
        }
    </script>

    <style>
        #items-table tr td {
            vertical-align: middle;
        }

        #items-table input,
        #items-table textarea {
            background: transparent !important;
            border: 1px solid transparent !important;
            transition: all 0.2s;
            display: block;
            width: 100%;
            padding: 0.75rem 0.5rem;
        }

        #items-table input:focus,
        #items-table textarea:focus {
            border-color: #dee2e6 !important;
            background: #fff !important;
            border-radius: 0.5rem;
        }
    </style>
@endsection