@extends('layouts.app')

@section('content')
<div x-data="{ 
    refresh() {
        window.location.reload();
    }
}" x-init="setInterval(() => refresh(), 60000)">
<div class="row g-4 mb-5">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded-4 text-primary me-3">
                    <i class="bi bi-send-fill fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Total Sent</div>
                    <div class="fs-3 fw-extrabold" id="totalSentDash">{{ $stats['total_sent'] }}</div>
                </div>
            </div>
            <div class="text-muted small">From {{ Auth::user()->office->name }}</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-success bg-opacity-10 p-3 rounded-4 text-success me-3">
                    <i class="bi bi-mailbox2 fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Total Received</div>
                    <div class="fs-3 fw-extrabold" id="totalReceivedDash">{{ $stats['total_received'] }}</div>
                </div>
            </div>
            <div class="text-muted small">At {{ Auth::user()->office->name }}</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-warning bg-opacity-10 p-3 rounded-4 text-warning me-3">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Pending Outgoing</div>
                    <div class="fs-3 fw-extrabold" id="pendingOutgoingDash">{{ $stats['pending_outgoing'] }}</div>
                </div>
            </div>
            <div class="text-muted small text-warning">Awaiting receipt</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-info bg-opacity-10 p-3 rounded-4 text-info me-3">
                    <i class="bi bi-cloud-download-fill fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Pending Incoming</div>
                    <div class="fs-3 fw-extrabold" id="pendingIncomingDash">{{ $stats['pending_incoming'] }}</div>
                </div>
            </div>
            <div class="text-muted small text-info">To be claimed</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Office Transmittals</span>
                <a href="{{ route('transmittals.index') }}" class="btn btn-sm btn-light rounded-pill">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Ref #</th>
                                <th>Date</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="recentTransmittalsBody">
                            @forelse($recentTransmittals as $t)
                            <tr>
                                <td class="fw-bold">{{ $t->reference_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($t->transmittal_date)->format('M d, Y') }}</td>
                                <td>{{ $t->senderOffice->name }}</td>
                                <td>{{ $t->receiverOffice->name }}</td>
                                <td>
                                    @php
                                        $userOfficeId = Auth::user()->office_id;
                                        $isAdmin = Auth::user()->hasAnyRole(['Super Admin', 'Regional MIS']);
                                        $displayStatus = $t->status;
                                        $badgeClass = strtolower($t->status);

                                        if (!$isAdmin && $t->status === 'Submitted') {
                                            if ($t->receiver_office_id == $userOfficeId) {
                                                $displayStatus = 'To Receive';
                                                $badgeClass = 'pending-arrival';
                                            } elseif ($t->sender_office_id == $userOfficeId) {
                                                $displayStatus = 'Pending Receipt';
                                                $badgeClass = 'submitted';
                                            }
                                        }
                                    @endphp
                                    <span class="status-badge bg-{{ $badgeClass }}">
                                        {{ $displayStatus }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('transmittals.show', $t) }}" class="btn btn-sm btn-navy rounded-3">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted italic">No recent transmittals found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($recentTransmittals->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $recentTransmittals->links() }}
            </div>
            @endif
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm h-100 bg-navy text-white" style="background-color: #001f3f;">
            <div class="card-body p-4 d-flex flex-column">
                <div>
                    <h3 class="fw-extrabold mb-3">Manage Your Documents</h3>
                    <p class="opacity-75 mb-0 small">Quickly create and track transmittals between Regional Office and Provincial Offices.</p>
                </div>
                <div class="d-grid gap-2" style="margin-top: 10pt;">
                    <a href="{{ route('transmittals.create') }}" class="btn btn-light rounded-3 fw-bold py-2">
                        <i class="bi bi-plus-lg me-2"></i>New Transmittal
                    </a>
                    <a href="{{ route('audit.index') }}" class="btn btn-outline-light rounded-3 fw-bold py-2">
                        <i class="bi bi-clock-history me-2"></i>Audit History
                    </a>
                </div>

                <div class="mt-4 pt-4 border-top border-white border-opacity-10">
                    <div class="small fw-bold text-uppercase opacity-50 mb-3" style="letter-spacing: 1px;">Standard Protocol</div>
                    <ul class="list-unstyled small mb-4 opacity-75">
                        <li class="mb-2"><i class="bi bi-check2-circle me-2"></i>Prepare copies in triplicate</li>
                        <li class="mb-2"><i class="bi bi-check2-circle me-2"></i>Verify Ref # before printing</li>
                        <li><i class="bi bi-check2-circle me-2"></i>Confirm receipt upon receiving the actual (hard) copy</li>
                    </ul>

                    <div class="mt-auto bg-white bg-opacity-10 rounded-4 p-3 text-center" 
                         x-data="{ 
                            time: '',
                            date: '',
                            updateTime() {
                                const now = new Date();
                                this.time = now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
                                this.date = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                            }
                         }" 
                         x-init="updateTime(); setInterval(() => updateTime(), 1000)">
                        <div class="small fw-bold text-uppercase opacity-50 mb-1" style="font-size: 0.65rem; letter-spacing: 2px;">Official PH Time</div>
                        <div class="h4 fw-extrabold mb-0 tabular-nums" x-text="time"></div>
                        <div class="small opacity-50" style="font-size: 0.75rem;" x-text="date"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
