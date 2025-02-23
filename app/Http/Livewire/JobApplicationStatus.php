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
        $this->authorize('update', $this->jobApplication);

        $oldStatus = $this->jobApplication->status;
        $this->jobApplication->update(['status' => 'accepted']);

        event(new ApplicationStatusNotification(
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
