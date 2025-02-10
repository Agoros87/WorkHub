<?php

namespace App\Livewire;

use App\Models\JobApplication;
use App\Models\ChatMessage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class JobApplicationChat extends Component
{
    use WithFileUploads;

    public $jobApplication;
    public $message = '';
    public $cv;
    public $temporaryCv;
    public $messages;

    public function mount(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = $this->jobApplication->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|min:1'
        ]);

        $this->jobApplication->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->message
        ]);

        $this->message = '';
        $this->loadMessages();
        $this->dispatch('messages-updated');
    }

    public function updatedCv()
    {
        if ($this->cv) {
            $this->validate([
                'cv' => 'mimes:pdf,doc,docx|max:2048'
            ]);
            
            $this->temporaryCv = $this->cv;
        }
    }

    public function uploadCV()
    {
        if (!$this->temporaryCv) {
            return;
        }

        $path = $this->temporaryCv->store('cvs', 'public');

        $this->jobApplication->update([
            'cv_path' => $path
        ]);

        $this->cv = null;
        $this->temporaryCv = null;

        session()->flash('message', 'CV subido correctamente');
    }

    public function deleteCV()
    {
        if ($this->jobApplication->cv_path) {
            Storage::disk('public')->delete($this->jobApplication->cv_path);
            
            $this->jobApplication->update([
                'cv_path' => null
            ]);

            session()->flash('message', 'CV eliminado correctamente');
        }
    }


    public function render()
    {
        return view('livewire.job-application-chat');
    }
}
