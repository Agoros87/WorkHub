<?php

namespace App\Events;

use App\Models\JobApplication;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public JobApplication $jobApplication,
        public string $oldStatus,
        public string $newStatus
    ) {}
}
