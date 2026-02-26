<?php

namespace App\Observers;

use App\Models\Transmittal;
use App\Models\TransmittalLog;
use Illuminate\Support\Facades\Auth;

class TransmittalObserver
{
    /**
     * Handle the Transmittal "created" event.
     *
     * @param  \App\Models\Transmittal  $transmittal
     * @return void
     */
    public function created(Transmittal $transmittal)
    {
        $status = $transmittal->status;
        TransmittalLog::create([
            'transmittal_id' => $transmittal->id,
            'user_id' => Auth::id(),
            'action' => $status,
            'description' => "Transmittal #{$transmittal->reference_number} was {$status}.",
        ]);
    }

    /**
     * Handle the Transmittal "updated" event.
     *
     * @param  \App\Models\Transmittal  $transmittal
     * @return void
     */
    public function updated(Transmittal $transmittal)
    {
        // Avoid duplicate logging if handled elsewhere or if no status/relevant change
        if ($transmittal->wasChanged('status')) {
            $newStatus = $transmittal->status;
            $oldStatus = $transmittal->getOriginal('status');
            
            $action = 'Updated';
            $description = "Transmittal #{$transmittal->reference_number} updated.";

            if ($newStatus === 'Submitted' && $oldStatus === 'Draft') {
                $action = 'Submitted';
                $description = "Transmittal #{$transmittal->reference_number} was Submitted.";
            } elseif ($newStatus === 'Received') {
                $action = 'Received';
                $receiver = Auth::user() ? Auth::user()->name : 'Unknown';
                $description = "Transmittal #{$transmittal->reference_number} marked as Received by {$receiver}.";
            } elseif ($newStatus === 'Draft' && $oldStatus === 'Submitted') {
                 $action = 'Reverted to Draft';
                 $description = "Transmittal #{$transmittal->reference_number} reverted to Draft.";
            }

            TransmittalLog::create([
                'transmittal_id' => $transmittal->id,
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
            ]);
        } elseif ($transmittal->wasChanged()) {
             // General update log
             TransmittalLog::create([
                'transmittal_id' => $transmittal->id,
                'user_id' => Auth::id(),
                'action' => 'Edited',
                'description' => "Transmittal #{$transmittal->reference_number} was Edited.",
            ]);
        }
    }
}
