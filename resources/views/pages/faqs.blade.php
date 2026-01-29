@extends('layouts.app')

@section('content')
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy">Dashboard</a></li>
            <li class="breadcrumb-item active">FAQs</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-extrabold mb-1">Frequently Asked Questions</h2>
            <p class="text-muted mb-0 small">Learn more about the DTI-R6 Transmittal Management System.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-9 mx-auto">
        <div class="accordion accordion-flush card shadow-sm border-0 rounded-4 overflow-hidden" id="faqAccordion">
            
            <!-- Question 1 -->
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        1. Why was the Microsoft Access–based system replaced?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body p-4 lh-relaxed">
                        The previous system, built on Microsoft Access, had limitations in scalability, multi-office access, and real-time collaboration. It required local installations, was prone to data inconsistencies, and lacked advanced tracking and audit features. The upgraded web-based system provides centralized access, real-time status updates, enhanced security, and seamless integration across all DTI Region VI offices, ensuring better efficiency and accountability.
                    </div>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        2. What are the key benefits of the web-based system?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body p-4 lh-relaxed">
                        <ul class="mb-0 ps-3">
                            <li class="mb-2">Centralized access from any office or device with an internet connection.</li>
                            <li class="mb-2">Real-time tracking of transmittals with status updates.</li>
                            <li class="mb-2">Comprehensive audit logs for accountability.</li>
                            <li class="mb-2">Excel-like interface for familiarity and ease of use.</li>
                            <li class="mb-2">Printable outputs compliant with official DTI formats.</li>
                            <li>Scalable for future expansion and additional modules.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        3. Can multiple users access the system at the same time?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body p-4 lh-relaxed">
                        Yes. The web-based system supports concurrent multi-user access, allowing staff from different offices to create, track, and update transmittals simultaneously.
                    </div>
                </div>
            </div>

            <!-- Question 4 -->
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        4. How does the system improve document tracking?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body p-4 lh-relaxed">
                        Each transmittal has a unique reference number. The system logs all actions (creation, updates, and receiving) with timestamps and user IDs, enabling real-time monitoring of document flow and reducing the risk of lost or delayed documents.
                    </div>
                </div>
            </div>

            <!-- Question 5 -->
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                        5. Is the system secure?
                    </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body p-4 lh-relaxed">
                        Yes. The system includes user authentication, role-based access, and audit logs to protect sensitive transmittal information. Regular backups and secure hosting ensure data integrity and availability.
                    </div>
                </div>
            </div>

            <!-- Question 6 -->
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                        6. Can I print transmittals in official DTI formats?
                    </button>
                </h2>
                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body p-4 lh-relaxed">
                        Absolutely. The system generates transmittals in formats that comply with official DTI documentation standards, ready for printing and distribution.
                    </div>
                </div>
            </div>

            <!-- Question 7 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                        7. What should I do if I encounter issues using the system?
                    </button>
                </h2>
                <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body p-4 lh-relaxed">
                        Users can contact the IT Support team at <strong>r06.mis@dti.gov.ph</strong>, or refer to the online help section within the system for step-by-step guides and troubleshooting tips.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) {
        background-color: var(--dti-navy) !important;
        color: white !important;
    }
    
    .accordion-button:not(.collapsed)::after {
        filter: brightness(0) invert(1) !important;
    }
    
    .accordion-button:focus {
        box-shadow: none !important;
        border-color: rgba(0,0,0,.125) !important;
    }
    
    .accordion-body {
        color: #4b5563 !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
    
    .accordion-collapse.show .accordion-body {
        color: #4b5563 !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
    
    .accordion-body strong {
        color: #1f2937 !important;
        opacity: 1 !important;
    }
    
    .accordion-body ul li {
        color: #4b5563 !important;
        opacity: 1 !important;
    }
    
    .lh-relaxed {
        line-height: 1.7 !important;
    }
</style>
@endsection
