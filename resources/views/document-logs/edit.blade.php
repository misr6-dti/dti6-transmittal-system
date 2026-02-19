@extends('layouts.app')

@section('content')
<div class="mb-8 print:hidden">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                 <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-navy hover:text-navy-light">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('document-logs.index') }}" class="ml-1 text-sm font-medium text-navy hover:text-navy-light md:ml-2">
                                Document Logs
                            </a>
                        </div>
                    </li>
                     <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">Edit Document Log</h2>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200">
    <div class="p-6 md:p-8">
        <form action="{{ route('document-logs.update', $documentLog) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Reference Number (Read-only) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Reference Number</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number', $documentLog->reference_number) }}" class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 font-mono" readonly>
                </div>

                <!-- Date -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Log Date</label>
                    <input type="date" name="log_date" value="{{ old('log_date', $documentLog->log_date->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('log_date') border-red-500 @enderror" required>
                    @error('log_date')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Receiver Division -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">To (Receiver Division)</label>
                    <select name="receiver_division_id" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('receiver_division_id') border-red-500 @enderror" required>
                        <option value="">Select Division</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('receiver_division_id', $documentLog->receiver_division_id) == $division->id ? 'selected' : '' }}>{{ $division->name }} ({{ $division->code }})</option>
                        @endforeach
                    </select>
                    @error('receiver_division_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Remarks (Optional)</label>
                    <input type="text" name="remarks" value="{{ old('remarks', $documentLog->remarks) }}" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all" placeholder="Any additional notes...">
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-navy">Documents / Items</h3>
                    <button type="button" onclick="addItem()" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold uppercase rounded-lg hover:bg-slate-200 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Item
                    </button>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 w-24">Qty</th>
                                <th class="px-4 py-3 w-32">Unit</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Remarks</th>
                                <th class="px-4 py-3 w-12"></th>
                            </tr>
                        </thead>
                        <tbody id="items-container" class="divide-y divide-slate-100">
                            <!-- Items will be re-populated by JS -->
                        </tbody>
                    </table>
                </div>
                 <!-- Validation for items array -->
                @error('items')
                    <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('document-logs.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-medium transition-colors text-sm">Cancel</a>
                
                @if($documentLog->status === 'Draft')
                    <button type="submit" name="status" value="Draft" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition-all">Save Draft</button>
                    <button type="submit" name="status" value="Submitted" class="px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">Submit Log</button>
                @else
                    <button type="submit" name="status" value="Submitted" class="px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">Update Log</button>
                @endif
            </div>
        </form>
    </div>
</div>

<template id="item-row-template">
    <tr class="item-row group hover:bg-slate-50">
        <td class="p-2">
            <input type="number" name="items[INDEX][quantity]" step="0.5" min="0" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm" placeholder="1" required>
        </td>
        <td class="p-2">
            <input type="text" name="items[INDEX][unit]" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm" placeholder="pcs">
        </td>
        <td class="p-2">
            <input type="text" name="items[INDEX][description]" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm" placeholder="Item description..." required>
        </td>
        <td class="p-2">
            <input type="text" name="items[INDEX][remarks]" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm" placeholder="Optional notes">
        </td>
        <td class="p-2 text-center">
            <button type="button" onclick="removeItem(this)" class="text-slate-400 hover:text-red-500 transition-colors p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </td>
    </tr>
</template>

<script>
    let itemCount = 0;

    function addItem(data = null, index = null) {
        if (index === null) index = itemCount++;
        const template = document.getElementById('item-row-template').innerHTML;
        const html = template.replace(/INDEX/g, index);
        const container = document.getElementById('items-container');
        container.insertAdjacentHTML('beforeend', html);

        if (data) {
            const row = container.lastElementChild;
            row.querySelector('[name$="[quantity]"]').value = data.quantity; // Ensure we use the exact value
            row.querySelector('[name$="[unit]"]').value = data.unit;
            row.querySelector('[name$="[description]"]').value = data.description;
            row.querySelector('[name$="[remarks]"]').value = data.remarks || '';
        }
    }

    function removeItem(button) {
        button.closest('tr').remove();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const existingItems = @json($documentLog->items);
        if (existingItems && existingItems.length > 0) {
            existingItems.forEach((item, index) => {
                // Ensure we pass the object with expected properties
                addItem({
                    quantity: item.quantity,
                    unit: item.unit,
                    description: item.description,
                    remarks: item.remarks
                }, index);
            });
            // Update itemCount so new items doesn't overwrite existing indices behavior if any
             itemCount = existingItems.length;
        } else {
            addItem();
        }
    });
</script>
@endsection
