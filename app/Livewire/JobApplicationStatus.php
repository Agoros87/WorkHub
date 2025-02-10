<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobApplication;

class JobApplicationStatus extends Component
{
    public JobApplication $jobApplication;

    public function mount(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public function accept()
    {
        if ($this->jobApplication->advertisement->user_id !== auth()->id()) {
            abort(403);
        }

        $this->jobApplication->update(['status' => 'accepted']);
        $this->dispatch('status-updated');
    }

    public function reject()
    {
        if ($this->jobApplication->advertisement->user_id !== auth()->id()) {
            abort(403);
        }

        $this->jobApplication->update(['status' => 'rejected']);
        $this->dispatch('status-updated');
    }

    public function render()
    {
        return view('livewire.job-application-status');
    }
}
