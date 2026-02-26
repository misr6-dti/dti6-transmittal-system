<?php

namespace App\Observers;

use App\Models\DocumentLog;
use App\Models\DocumentLogEntry;
use Illuminate\Support\Facades\Auth;

class DocumentLogObserver
{
    /**
     * Handle the DocumentLog "created" event.
     *
     * @param  \App\Models\DocumentLog  $documentLog
     * @return void
     */
    public function created(DocumentLog $documentLog)
    {
        $status = $documentLog->status;
        DocumentLogEntry::create([
            'document_log_id' => $documentLog->id,
            'user_id' => Auth::id(),
            'action' => $status,
            'description' => "Document #{$documentLog->reference_number} was {$status}.",
        ]);
    }

    /**
     * Handle the DocumentLog "updated" event.
     *
     * @param  \App\Models\DocumentLog  $documentLog
     * @return void
     */
    public function updated(DocumentLog $documentLog)
    {
        if ($documentLog->wasChanged('status')) {
            $newStatus = $documentLog->status;
            $oldStatus = $documentLog->getOriginal('status');
            
            $action = 'Updated';
            $description = "Document #{$documentLog->reference_number} updated.";

            if ($newStatus === 'Submitted' && $oldStatus === 'Draft') {
                $action = 'Submitted';
                $description = "Document #{$documentLog->reference_number} was Submitted.";
            } elseif ($newStatus === 'Received') {
                $action = 'Received';
                $receiver = Auth::user() ? Auth::user()->name : 'Unknown';
                $description = "Document #{$documentLog->reference_number} marked as Received by {$receiver}.";
            } elseif ($newStatus === 'Draft' && $oldStatus === 'Submitted') {
                 $action = 'Reverted to Draft';
                 $description = "Document #{$documentLog->reference_number} reverted to Draft.";
            }

            DocumentLogEntry::create([
                'document_log_id' => $documentLog->id,
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
            ]);
        } elseif ($documentLog->wasChanged()) {
             DocumentLogEntry::create([
                'document_log_id' => $documentLog->id,
                'user_id' => Auth::id(),
                'action' => 'Edited',
                'description' => "Document #{$documentLog->reference_number} was Edited.",
            ]);
        }
    }
}
