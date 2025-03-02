<?php

namespace App\Listeners;

use App\Events\ApplicationStatusNotification;
use App\Mail\ApplicationStatusEmail;
use Illuminate\Support\Facades\Mail;

class SendApplicationStatusEmail
{
    public function handle(ApplicationStatusNotification $event): void
    {
        $user = $event->jobApplication->user; // Guarda el usuario que ha aplicado al trabajo

        Mail::to($user->email)->send( //Envía un email al email del usuario con la instancia de la clase mailabe ApplicationStatusEmail
            new ApplicationStatusEmail(
                $event->jobApplication,
                $event->oldStatus,
                $event->newStatus
            )
        );
    }
}
