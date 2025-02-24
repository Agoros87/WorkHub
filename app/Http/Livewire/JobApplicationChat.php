<?php

namespace App\Http\Livewire;

use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class JobApplicationChat extends Component
{
    use WithFileUploads;

    public $message = '';

    public $cv;

    public $messages;

    public $jobApplication;

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

    public function uploadCV()
    {
        if (! $this->cv) {
            session()->flash('error', 'Debes de seleccionar un archivo antes');

            return;
        }

        $this->validateCV();

        $this->deleteOldCV();

        $path = $this->storeNewCVInDisk();
        $this->updateCVPathInDataBase($path);

        $this->resetCVInput();
        session()->flash('message', 'CV subido correctamente');
    }

    public function deleteCV()
    {
        if ($this->jobApplication->cv_path) {
            $this->deleteOldCV();
            $this->updateCVPathInDataBase(null);

            session()->flash('message', 'CV eliminado correctamente.');
        }
    }

    protected function validateCV()
    {
        $this->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);
    }

    protected function deleteOldCV()
    {
        if ($this->jobApplication->cv_path) {
            Storage::disk('public')->delete($this->jobApplication->cv_path);
        }
    }

    protected function storeNewCVInDisk()
    {
        return $this->cv->store('cvs', 'public');
    }

    protected function updateCVPathInDataBase($path)
    {
        $this->jobApplication->update(['cv_path' => $path]);
    }

    protected function resetCVInput()
    {
        $this->reset('cv');
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string',
        ]);

        $this->jobApplication->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);

        $this->reset('message');
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.job-application-chat');
    }
}
