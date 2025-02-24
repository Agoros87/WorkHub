<?php

namespace App\Listeners;

use App\Events\ApplicationStatusNotification;
use App\Mail\ApplicationStatusEmail;
use Illuminate\Support\Facades\Mail;

class SendApplicationStatusEmail
{
    public function handle(ApplicationStatusNotification $event): void
    {
        $user = $event->jobApplication->user;

        Mail::to($user->email)->send(
            new ApplicationStatusEmail(
                $event->jobApplication,
                $event->oldStatus,
                $event->newStatus
            )
        );
    }
}
