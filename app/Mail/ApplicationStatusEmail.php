<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JobApplication $jobApplication,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function build()
    {
        return $this->view('emails.application-status-email')
            ->subject('Actualización del Estado de tu Aplicación - WorkHub');
    }
}
