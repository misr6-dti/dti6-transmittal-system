<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Transmittal;

class RecentTransmittals extends Component
{
    public $transmittals;

    /**
     * Create a new component instance.
     */
    public function __construct($transmittals)
    {
        $this->transmittals = $transmittals;
    }

    /**
     * Get the status display data for a transmittal.
     */
    public function getStatusData(Transmittal $transmittal): array
    {
        $user = Auth::user();
        $userOfficeId = $user->office_id;
        $isAdmin = $user->hasRole('Admin');
        
        $status = $transmittal->status;
        $badgeClass = strtolower($status);
        $displayStatus = $status;

        if (!$isAdmin && $status === 'Submitted') {
            if ($transmittal->receiver_office_id == $userOfficeId) {
                $displayStatus = 'To Receive';
                $badgeClass = 'pending-arrival';
            } elseif ($transmittal->sender_office_id == $userOfficeId) {
                $displayStatus = 'Pending Receipt';
                $badgeClass = 'submitted';
            }
        }

        return [
            'label' => $displayStatus,
            'class' => $badgeClass,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.dashboard.recent-transmittals');
    }
}
