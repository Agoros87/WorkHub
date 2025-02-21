<?php

namespace App\Http\Livewire;

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

        $this->jobApplication->update(['status' => 'accepted']);
        $this->dispatch('status-updated');
    }

    public function reject()
    {
        $this->authorize('update', $this->jobApplication);

        $this->jobApplication->update(['status' => 'rejected']);
        $this->dispatch('status-updated');
    }

    public function render()
    {
        return view('livewire.job-application-status');
    }
}
