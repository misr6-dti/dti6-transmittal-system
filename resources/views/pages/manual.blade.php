@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">User Manual</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-extrabold mb-0">System User Manual</h2>
            <p class="text-muted">Documentation for DTI-R6 Transmittal Management System.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-navy no-print">
            <i class="bi bi-printer me-2"></i>Print Manual
        </button>
    </div>
</div>

<div class="row">
    <!-- Sidebar Navigation -->
    <div class="col-lg-3 no-print">
        <div class="card shadow-sm border-0 sticky-top" style="top: 6rem;">
            <div class="card-body p-0">
                <div class="list-group list-group-flush rounded-4">
                    <a href="#introduction" class="list-group-item list-group-item-action py-3 fw-bold">1. Introduction</a>
                    <a href="#roles" class="list-group-item list-group-item-action py-3 fw-bold">2. User Roles & Access</a>
                    <a href="#transmittal-flow" class="list-group-item list-group-item-action py-3 fw-bold">3. Transmittal Workflow</a>
                    <a href="#receiving" class="list-group-item list-group-item-action py-3 fw-bold">4. Confirming Receipt</a>
                    <a href="#audit" class="list-group-item list-group-item-action py-3 fw-bold">5. Audit History</a>
                    @hasanyrole('Super Admin|Regional MIS')
                    <a href="#admin" class="list-group-item list-group-item-action py-3 fw-bold text-primary">6. Administration</a>
                    @endhasanyrole
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Content -->
    <div class="col-lg-9">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
            <div class="card-body p-4 p-md-5">
                
                <!-- Section: Introduction -->
                <section id="introduction" class="mb-5">
                    <h4 class="fw-bold border-bottom pb-3 mb-4 text-navy">1. Introduction</h4>
                    <p class="lh-relaxed text-muted">
                        Welcome to the <strong>DTI Region VI Transmittal Management System (TMS)</strong>. This web-based platform is designed to replace legacy manual tracking methods with a centralized, secure, and real-time document ledger. 
                    </p>
                    <p class="lh-relaxed text-muted">
                        The system ensures that every document moved between the Regional Office and Provincial Offices is recorded, timestamped, and verified by authorized personnel.
                    </p>
                </section>

                <!-- Section: Roles -->
                <section id="roles" class="mb-5">
                    <h4 class="fw-bold border-bottom pb-3 mb-4 text-navy">2. User Roles & Access</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4 h-100 border-start border-4 border-navy">
                                <h6 class="fw-bold">Office Staff / Head</h6>
                                <p class="small text-muted mb-0">Manage office-specific document flows. Create transmittals and acknowledge receipt of incoming documents intended for their office.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4 h-100 border-start border-4 border-primary">
                                <h6 class="fw-bold">Regional MIS / Super Admin</h6>
                                <p class="small text-muted mb-0">System-wide oversight. Manage users, roles, and offices. Authorized to view the global system audit trail and provide technical support.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Transmittal Flow -->
                <section id="transmittal-flow" class="mb-5">
                    <h4 class="fw-bold border-bottom pb-3 mb-4 text-navy">3. Step-by-Step Operational Procedure</h4>
                    
                    <div class="mb-5">
                        <div class="badge bg-navy mb-2">PHASE 1: THE TRANSMITTING OFFICE</div>
                        <h6 class="fw-extrabold text-uppercase small mb-3">Initiating the Document Movement</h6>
                        
                        <div class="ms-3 border-start ps-4 py-2">
                            <div class="mb-4">
                                <div class="fw-bold text-dark d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-1-circle me-2"></i>Digital Encoding</span>
                                    <button type="button" class="btn btn-sm btn-outline-navy py-0 px-2 no-print" data-bs-toggle="modal" data-bs-target="#imgEncoding">
                                        <i class="bi bi-image me-1"></i>View Screenshot
                                    </button>
                                </div>
                                <p class="small text-muted mb-0 mt-2">Navigate to <strong>"New Entry"</strong>. Fill in the Destination Office and generate your Reference Number. List all items meticulously, ensuring quantities and units match the physical items.</p>
                            </div>
                            <div class="mb-4">
                                <div class="fw-bold text-dark"><i class="bi bi-2-circle me-2"></i>Preparation in Triplicate</div>
                                <p class="small text-muted mb-0">After clicking <strong>Submit</strong>, download the official PDF. Print <strong>three (3) copies</strong> of the generated form.</p>
                            </div>
                            <div class="mb-4">
                                <div class="fw-bold text-dark"><i class="bi bi-3-circle me-2"></i>Physical Bundle</div>
                                <p class="small text-muted mb-0">Attach the original and duplicate printed forms to the documents/items. Retain the third copy as your initial file copy.</p>
                            </div>
                            <div>
                                <div class="fw-bold text-dark"><i class="bi bi-4-circle me-2"></i>Dispatch</div>
                                <p class="small text-muted mb-0">Send the physical bundle to the designated office node via the approved regional courier or staff movement.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="badge bg-primary mb-2">PHASE 2: THE RECEIVING OFFICE</div>
                        <h6 class="fw-extrabold text-uppercase small mb-3">Verification & Closure</h6>
                        
                        <div class="ms-3 border-start ps-4 py-2 border-primary">
                            <div class="mb-4">
                                <div class="fw-bold text-dark"><i class="bi bi-1-circle me-2"></i>Physical Receipt</div>
                                <p class="small text-muted mb-0">Upon arrival of the items, retrieve the attached printed transmittal forms.</p>
                            </div>
                            <div class="mb-4">
                                <div class="fw-bold text-dark"><i class="bi bi-2-circle me-2"></i>Content Verification</div>
                                <p class="small text-muted mb-0">Open the bundle and verify that all items listed on the printed form are physically present. Inspect for damages or discrepancies.</p>
                            </div>
                            <div class="mb-4">
                                <div class="fw-bold text-dark"><i class="bi bi-3-circle me-2"></i>Manual Signing</div>
                                <p class="small text-muted mb-0">Sign both the original and duplicate printed forms. Return the signed duplicate to the courier or the sender.</p>
                            </div>
                            <div>
                                <div class="fw-bold text-dark d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-4-circle me-2"></i>Digital Acknowledgement</span>
                                    <button type="button" class="btn btn-sm btn-outline-navy py-0 px-2 no-print" data-bs-toggle="modal" data-bs-target="#imgReceiving">
                                        <i class="bi bi-image me-1"></i>View Screenshot
                                    </button>
                                </div>
                                <p class="small text-muted mb-0 mt-2">Log in to the <strong>TMS-R6 Portal</strong>. Locate the transmittal under the <strong>To Receive</strong> status in your ledger. Click the prominent <strong>green "Receive" button</strong> to officially close the digital trail.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Receiving Rule (Simplified) -->
                <section id="receiving" class="mb-5">
                    <h4 class="fw-bold border-bottom pb-3 mb-4 text-navy">4. Critical Security Protocols</h4>
                    <div class="alert alert-warning border-0 rounded-4 p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-shield-lock-fill fs-2 text-warning me-3"></i>
                            <h5 class="fw-bold mb-0">Digital-Physical Synchronization</h5>
                        </div>
                        <ul class="mb-0 ps-3">
                            <li class="mb-2"><strong>The Arrival Rule:</strong> Never trigger the "Mark as Received" button before you have hold of the physical hard copy.</li>
                            <li class="mb-2"><strong>The Verification Rule:</strong> Digital confirmation signifies that you have inspected the items and they match the description.</li>
                            <li><strong>The Audit Rule:</strong> Every click is logged. If you confirm a transmittal but the items are missing, the audit trail will point to your ID as the last point of verification.</li>
                        </ul>
                    </div>
                </section>

                <!-- Section: Audit -->
                <section id="audit" class="mb-5">
                    <h4 class="fw-bold border-bottom pb-3 mb-4 text-navy">5. Audit History</h4>
                    <p class="small text-muted mb-3">
                        Every action in the system creates a permanent footprint. Transparency is enforced through the <strong>System Audit Trail</strong>:
                    </p>
                    <ul class="small text-muted ps-3">
                        <li class="mb-2"><strong>Origin Office</strong>: Where the change was made.</li>
                        <li class="mb-2"><strong>Recipient Office</strong>: The target of the document movement.</li>
                        <li class="mb-2"><strong>Action Detail</strong>: Exactly what happened (Submitted, Edited, Received).</li>
                        <li><strong>Authorized By</strong>: The full name of the officer who performed the action.</li>
                    </ul>
                </section>

                <!-- Section: Admin (Conditional) -->
                @hasanyrole('Super Admin|Regional MIS')
                <section id="admin" class="mb-5">
                    <h4 class="fw-bold border-bottom pb-3 mb-4 text-primary">6. MIS Administration</h4>
                    <div class="bg-light p-4 rounded-4">
                        <h6 class="fw-bold">User / Role Management</h6>
                        <p class="small text-muted mb-4">Admins can manage user accounts, assign roles (Super Admin, Regional MIS, Office Head, Office Staff), and define granular permissions.</p>
                        
                        <h6 class="fw-bold">Global Surveillance</h6>
                        <p class="small text-muted mb-0">Administrators are the only users who can see transmittals across ALL offices. This allows for system-wide auditing and resolution of document delivery status disputes.</p>
                    </div>
                </section>
                @endhasanyrole

            </div>
        </div>
    </div>
</div>

<!-- Modals for Screenshots -->
<div class="modal fade no-print" id="imgEncoding" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden border-0 shadow-lg">
            <div class="modal-header bg-navy text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-window me-2"></i>Visual Guide: New Transmittal Entry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-light">
                <img src="{{ asset('images/manual/encoding.png') }}" class="img-fluid w-100" alt="Encoding Screenshot">
            </div>
            <div class="modal-footer bg-white py-2">
                <p class="small text-muted mb-0 italic">Note: This is a representative interface based on the DTI-R6 Design System.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade no-print" id="imgReceiving" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden border-0 shadow-lg">
            <div class="modal-header bg-navy text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-window me-2"></i>Visual Guide: Confirming Receipt</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-light">
                <img src="{{ asset('images/manual/receiving.png') }}" class="img-fluid w-100" alt="Receiving Screenshot">
            </div>
            <div class="modal-footer bg-white py-2">
                <p class="small text-muted mb-0 italic">Note: This is a representative interface based on the DTI-R6 Design System.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-outline-navy { color: var(--dti-navy); border-color: var(--dti-navy); }
    .btn-outline-navy:hover { background-color: var(--dti-navy); color: white; }
    section { scroll-margin-top: 6rem; }
    .list-group-item.active { background-color: var(--dti-navy); border-color: var(--dti-navy); }
    .lh-relaxed { line-height: 1.8; }
    .border-navy { border-color: var(--dti-navy) !important; }
    @media print {
        .col-lg-3 { display: none !important; }
        .col-lg-9 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
</style>
@endsection
