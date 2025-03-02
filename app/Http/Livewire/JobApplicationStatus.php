<?php

namespace App\Http\Livewire;

use App\Events\ApplicationStatusNotification;
use App\Models\JobApplication;
use Livewire\Component;

class JobApplicationStatus extends Component
{
    public JobApplication $jobApplication;

    public function mount(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;

    }

    public function accept()
    {
        $this->authorize('update', $this->jobApplication); //Comprueba si es el dueño del anuncio

        $oldStatus = $this->jobApplication->status; //Guarda el estado anterior
        $this->jobApplication->update(['status' => 'accepted']); //Actualiza el estado a aceptado

        event(new ApplicationStatusNotification( //Dispara un evento creando una instancia de applicationstatusnotification jobApplication, el estado anterior y el nuevo estado
            $this->jobApplication,
            $oldStatus,
            'accepted'
        ));
    }

    public function reject()
    {
        $this->authorize('update', $this->jobApplication);

        $oldStatus = $this->jobApplication->status;
        $this->jobApplication->update(['status' => 'rejected']);

        event(new ApplicationStatusNotification(
            $this->jobApplication,
            $oldStatus,
            'rejected'
        ));
    }

    public function render()
    {
        return view('livewire.job-application-status');
    }
}
