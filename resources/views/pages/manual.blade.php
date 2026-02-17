@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 no-print">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-navy hover:text-navy-light font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">User Manual</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">System User Manual</h2>
            <p class="text-slate-500 text-sm">Documentation for DTI-R6 Transmittal Management System.</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-200 text-navy text-sm font-medium rounded-xl hover:bg-slate-50 transition-colors print:hidden">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Manual
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Sidebar Navigation -->
    <div class="lg:col-span-1 no-print">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 sticky top-24 overflow-hidden">
            <nav class="divide-y divide-slate-100">
                <a href="#introduction" class="block px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-navy transition-colors">1. Introduction</a>
                <a href="#roles" class="block px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-navy transition-colors">2. User Roles & Access</a>
                <a href="#transmittal-flow" class="block px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-navy transition-colors">3. Transmittal Workflow</a>
                <a href="#receiving" class="block px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-navy transition-colors">4. Confirming Receipt</a>
                <a href="#audit" class="block px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-navy transition-colors">5. Audit History</a>
                @hasanyrole('Super Admin|Regional MIS')
                <a href="#admin" class="block px-4 py-3 text-sm font-bold text-blue-600 hover:bg-blue-50 transition-colors">6. Administration</a>
                @endhasanyrole
            </nav>
        </div>
    </div>

    <!-- Manual Content -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
            <div class="p-6 md:p-10">

                <!-- Section: Introduction -->
                <section id="introduction" class="mb-10 scroll-mt-24">
                    <h4 class="font-bold text-lg border-b border-slate-200 pb-3 mb-4 text-navy">1. Introduction</h4>
                    <p class="text-slate-500 leading-relaxed">
                        Welcome to the <strong>DTI Region VI Transmittal Management System (TMS)</strong>. This web-based platform is designed to replace legacy manual tracking methods with a centralized, secure, and real-time document ledger.
                    </p>
                    <p class="text-slate-500 leading-relaxed">
                        The system ensures that every document moved between the Regional Office and Provincial Offices is recorded, timestamped, and verified by authorized personnel.
                    </p>
                </section>

                <!-- Section: Roles -->
                <section id="roles" class="mb-10 scroll-mt-24">
                    <h4 class="font-bold text-lg border-b border-slate-200 pb-3 mb-4 text-navy">2. User Roles & Access</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-xl border-l-4 border-navy">
                            <h6 class="font-bold text-slate-800">Office Staff / Head</h6>
                            <p class="text-sm text-slate-500 mt-1">Manage office-specific document flows. Create transmittals and acknowledge receipt of incoming documents intended for their office.</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border-l-4 border-blue-500">
                            <h6 class="font-bold text-slate-800">Regional MIS / Super Admin</h6>
                            <p class="text-sm text-slate-500 mt-1">System-wide oversight. Manage users, roles, and offices. Authorized to view the global system audit trail and provide technical support.</p>
                        </div>
                    </div>
                </section>

                <!-- Section: Transmittal Flow -->
                <section id="transmittal-flow" class="mb-10 scroll-mt-24">
                    <h4 class="font-bold text-lg border-b border-slate-200 pb-3 mb-4 text-navy">3. Step-by-Step Operational Procedure</h4>

                    <div class="mb-8">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-navy text-white mb-2">PHASE 1: THE TRANSMITTING OFFICE</span>
                        <h6 class="font-extrabold text-xs uppercase text-slate-600 tracking-wider mb-3">Initiating the Document Movement</h6>

                        <div class="ml-3 border-l-2 border-slate-200 pl-4 py-2 space-y-4">
                            <div>
                                <div class="font-bold text-slate-800 flex justify-between items-center">
                                    <span>① Digital Encoding</span>
                                    <button type="button"
                                        class="px-2 py-1 text-xs font-medium text-navy bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors print:hidden"
                                        @click="$store.imageModal.open('{{ asset('images/manual/encoding.png') }}', 'Visual Guide: New Transmittal Entry')">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        View Screenshot
                                    </button>
                                </div>
                                <p class="text-sm text-slate-500 mt-2">Navigate to <strong>"New Entry"</strong>. Fill in the Destination Office and generate your Reference Number. List all items meticulously, ensuring quantities and units match the physical items.</p>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">② Preparation in Triplicate</div>
                                <p class="text-sm text-slate-500">After clicking <strong>Submit</strong>, download the official PDF. Print <strong>three (3) copies</strong> of the generated form.</p>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">③ Physical Bundle</div>
                                <p class="text-sm text-slate-500">Attach the original and duplicate printed forms to the documents/items. Retain the third copy as your initial file copy.</p>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">④ Dispatch</div>
                                <p class="text-sm text-slate-500">Send the physical bundle to the designated office node via the approved regional courier or staff movement.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white mb-2">PHASE 2: THE RECEIVING OFFICE</span>
                        <h6 class="font-extrabold text-xs uppercase text-slate-600 tracking-wider mb-3">Verification & Closure</h6>

                        <div class="ml-3 border-l-2 border-blue-300 pl-4 py-2 space-y-4">
                            <div>
                                <div class="font-bold text-slate-800">① Physical Receipt</div>
                                <p class="text-sm text-slate-500">Upon arrival of the items, retrieve the attached printed transmittal forms.</p>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">② Content Verification</div>
                                <p class="text-sm text-slate-500">Open the bundle and verify that all items listed on the printed form are physically present. Inspect for damages or discrepancies.</p>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">③ Manual Signing</div>
                                <p class="text-sm text-slate-500">Sign both the original and duplicate printed forms. Return the signed duplicate to the courier or the sender.</p>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 flex justify-between items-center">
                                    <span>④ Digital Acknowledgement</span>
                                    <button type="button"
                                        class="px-2 py-1 text-xs font-medium text-navy bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors print:hidden"
                                        @click="$store.imageModal.open('{{ asset('images/manual/receiving.png') }}', 'Visual Guide: Confirming Receipt')">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        View Screenshot
                                    </button>
                                </div>
                                <p class="text-sm text-slate-500 mt-2">Log in to the <strong>TMS-R6 Portal</strong>. Locate the transmittal under the <strong>To Receive</strong> status in your ledger. Click the prominent <strong>green "Receive" button</strong> to officially close the digital trail.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Receiving Rule (Simplified) -->
                <section id="receiving" class="mb-10 scroll-mt-24">
                    <h4 class="font-bold text-lg border-b border-slate-200 pb-3 mb-4 text-navy">4. Critical Security Protocols</h4>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                        <div class="flex items-center mb-3">
                            <svg class="w-8 h-8 text-amber-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            <h5 class="font-bold text-slate-800">Digital-Physical Synchronization</h5>
                        </div>
                        <ul class="space-y-2 text-sm text-slate-600 list-disc pl-5">
                            <li><strong>The Arrival Rule:</strong> Never trigger the "Mark as Received" button before you have hold of the physical hard copy.</li>
                            <li><strong>The Verification Rule:</strong> Digital confirmation signifies that you have inspected the items and they match the description.</li>
                            <li><strong>The Audit Rule:</strong> Every click is logged. If you confirm a transmittal but the items are missing, the audit trail will point to your ID as the last point of verification.</li>
                        </ul>
                    </div>
                </section>

                <!-- Section: Audit -->
                <section id="audit" class="mb-10 scroll-mt-24">
                    <h4 class="font-bold text-lg border-b border-slate-200 pb-3 mb-4 text-navy">5. Audit History</h4>
                    <p class="text-sm text-slate-500 mb-3">
                        Every action in the system creates a permanent footprint. Transparency is enforced through the <strong>System Audit Trail</strong>:
                    </p>
                    <ul class="text-sm text-slate-500 space-y-2 list-disc pl-5">
                        <li><strong>Origin Office</strong>: Where the change was made.</li>
                        <li><strong>Recipient Office</strong>: The target of the document movement.</li>
                        <li><strong>Action Detail</strong>: Exactly what happened (Submitted, Edited, Received).</li>
                        <li><strong>Authorized By</strong>: The full name of the officer who performed the action.</li>
                    </ul>
                </section>

                <!-- Section: Admin (Conditional) -->
                @hasanyrole('Super Admin|Regional MIS')
                <section id="admin" class="mb-10 scroll-mt-24">
                    <h4 class="font-bold text-lg border-b border-slate-200 pb-3 mb-4 text-blue-600">6. MIS Administration</h4>
                    <div class="bg-slate-50 p-5 rounded-xl space-y-4">
                        <div>
                            <h6 class="font-bold text-slate-800">User / Role Management</h6>
                            <p class="text-sm text-slate-500 mt-1">Admins can manage user accounts, assign roles (Super Admin, Regional MIS, Office Head, Office Staff), and define granular permissions.</p>
                        </div>
                        <div>
                            <h6 class="font-bold text-slate-800">Global Surveillance</h6>
                            <p class="text-sm text-slate-500 mt-1">Administrators are the only users who can see transmittals across ALL offices. This allows for system-wide auditing and resolution of document delivery status disputes.</p>
                        </div>
                    </div>
                </section>
                @endhasanyrole

            </div>
        </div>
    </div>
</div>

<!-- Image Modal (Alpine.js) -->
<div x-data x-show="$store.imageModal.visible" x-cloak
     class="fixed inset-0 z-50 overflow-y-auto print:hidden" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div x-show="$store.imageModal.visible"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75"
             @click="$store.imageModal.close()"></div>
        <div x-show="$store.imageModal.visible"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-xl overflow-hidden max-w-5xl w-full">
            <div class="bg-navy text-white px-6 py-3 flex justify-between items-center">
                <h5 class="font-bold text-sm" x-text="$store.imageModal.title"></h5>
                <button @click="$store.imageModal.close()" class="text-white/70 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="bg-slate-50 p-0">
                <img :src="$store.imageModal.src" class="w-full" alt="Screenshot">
            </div>
            <div class="bg-white px-6 py-2">
                <p class="text-sm text-slate-500 italic">Note: This is a representative interface based on the DTI-R6 Design System.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('imageModal', {
        visible: false,
        src: '',
        title: '',
        open(src, title) {
            this.src = src;
            this.title = title;
            this.visible = true;
        },
        close() {
            this.visible = false;
        }
    });
});
</script>

<style>
    @media print {
        .lg\:col-span-1 { display: none !important; }
        .lg\:col-span-3 { grid-column: span 4 / span 4 !important; }
    }
</style>
@endsection
