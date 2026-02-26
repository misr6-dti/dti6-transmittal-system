@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-slate-200 pb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center">
            <div class="bg-navy bg-opacity-10 p-3 rounded-xl text-navy mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-navy">New Transmittal</h2>
                <p class="text-slate-500 text-sm">Record and submit a new document transfer protocol.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('transmittals.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-medium transition-colors">
                Cancel
            </a>
        </div>
    </div>
</div>

<form action="{{ route('transmittals.store') }}" method="POST" x-data="transmittalForm()">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Header Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 h-full">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center bg-slate-50/50 rounded-t-2xl">
                <svg class="w-5 h-5 text-navy mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold text-navy">Header Info</span>
            </div>
            <div class="p-6">
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Reference Number</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number', $nextRef) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy font-bold text-navy transition-all @error('reference_number') border-red-500 @enderror" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Transmittal Date</label>
                    <input type="date" name="transmittal_date" value="{{ old('transmittal_date', date('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-slate-600 transition-all" required>
                </div>
            </div>
        </div>

        <!-- Routing -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 h-full">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center bg-slate-50/50 rounded-t-2xl">
                <svg class="w-5 h-5 text-navy mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-bold text-navy">Routing</span>
            </div>
            <div class="p-6">
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Originating Office</label>
                    <input type="text" value="{{ Auth::user()->office->name }}" class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Destination Office</label>
                    <select name="receiver_office_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-slate-600 transition-all appearance-none" required>
                        <option value="">Select Target Office...</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ old('receiver_office_id') == $office->id ? 'selected' : '' }}>{!! $office->display_name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Additional Notes -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 h-full">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center bg-slate-50/50 rounded-t-2xl">
                <svg class="w-5 h-5 text-navy mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                <span class="font-bold text-navy">Additional Notes</span>
            </div>
            <div class="p-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Executive Remarks</label>
                <textarea name="remarks" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-slate-600 transition-all" rows="4" placeholder="Optional context...">{{ old('remarks') }}</textarea>
            </div>
        </div>
    </div>

    <!-- VAPT V-05: Sensitive data advisory -->
    <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5 mb-8 flex items-start shadow-sm">
        <svg class="w-6 h-6 text-amber-500 mt-1 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <div>
            <h4 class="font-bold text-amber-800 mb-1">Security Advisory</h4>
            <p class="text-amber-700 text-sm">Do not enter sensitive personal information (e.g., full names, addresses, ID numbers) in the <span class="font-bold">Description</span> or <span class="font-bold">Remarks</span> fields. These fields are visible via the public QR Code tracking page without requiring login.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-8 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-navy mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="font-bold text-navy">Enclosure Items</span>
            </div>
            <div class="text-xs text-slate-500 font-medium bg-white px-2 py-1 rounded-md border border-slate-200">At least one item required. Tab key supported.</div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600" id="items-table">
                <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <tr>
                        <th width="60" class="px-4 py-3 text-center">#</th>
                        <th width="100" class="px-4 py-3">Qty</th>
                        <th width="120" class="px-4 py-3">Unit</th>
                        <th class="px-4 py-3">Description / Particulars</th>
                        <th class="px-4 py-3">Item Remarks</th>
                        <th width="60" class="px-4 py-3 text-center"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2 text-center text-slate-400 font-medium" x-text="index + 1"></td>
                            <td>
                                <input type="number" 
                                       :name="'items['+index+'][quantity]'" 
                                       x-model="item.quantity" 
                                       class="w-full bg-transparent border-0 text-center font-bold focus:ring-0 p-0 text-navy placeholder-slate-300" 
                                       placeholder="0"
                                       @keydown.enter.prevent="focusNext(index, 'unit')">
                            </td>
                            <td>
                                <input type="text" 
                                       :name="'items['+index+'][unit]'" 
                                       x-model="item.unit" 
                                       class="w-full bg-transparent border-0 focus:ring-0 p-0 text-slate-600 placeholder-slate-300" 
                                       placeholder="e.g. pcs"
                                       @keydown.enter.prevent="focusNext(index, 'description')">
                            </td>
                            <td>
                                <textarea :name="'items['+index+'][description]'" 
                                          x-model="item.description" 
                                          rows="1"
                                          class="w-full bg-transparent border-0 focus:ring-0 p-0 text-slate-600 placeholder-slate-300 resize-none"
                                          placeholder="Document code or title..."
                                          @keydown.enter.prevent="focusNext(index, 'remarks')"></textarea>
                            </td>
                            <td>
                                <input type="text" 
                                       :name="'items['+index+'][remarks]'" 
                                       x-model="item.remarks" 
                                       class="w-full bg-transparent border-0 focus:ring-0 p-0 text-slate-500 placeholder-slate-300 italic" 
                                       placeholder="Optional..."
                                       @keydown.enter.prevent="addRowAndFocus(index)">
                            </td>
                            <td class="text-center align-middle pr-3">
                                <button type="button" @click="removeItem(index)" class="text-red-400 hover:text-red-600 transition-colors" x-show="items.length > 1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            <button type="button" @click="addItem()" class="inline-flex items-center px-4 py-2 border border-navy text-navy rounded-xl hover:bg-navy hover:text-white transition-colors text-sm font-bold shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Another Row
            </button>
        </div>
    </div>

    <div class="flex justify-end gap-3 mb-8">
        <button type="reset" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-bold transition-colors">Reset</button>
        <button type="submit" name="status" value="Draft" class="px-6 py-3 border border-navy text-navy rounded-xl hover:bg-navy/5 font-bold transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Save as Draft
        </button>
        <button type="submit" name="status" value="Submitted" class="px-8 py-3 bg-navy text-white rounded-xl hover:bg-navy-light font-bold shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Finalize & Submit Form
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
                // Simplified focus logic for inputs
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
    /* Custom input table styles that Tailwind can't easily capture with arbitrary values */
    #items-table tr {
        transition: all 0.2s;
    }
    #items-table input:focus, 
    #items-table textarea:focus {
        outline: none;
        background-color: #ffffff;
        border-radius: 0.375rem;
        box-shadow: 0 0 0 2px rgba(0, 31, 63, 0.1);
    }
</style>
@endsection
