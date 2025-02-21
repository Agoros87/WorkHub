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
        if (!$this->cv) {
            session()->flash('error', 'Debes de seleccionar un archivo antes');
            return;
        }

        $this->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // Eliminar el CV anterior si existe
        if ($this->jobApplication->cv_path) {
            Storage::disk('public')->delete($this->jobApplication->cv_path);
        }

        // Guardo el nuevo CV
        $path = $this->cv->store('cvs', 'public');

        // Actualizo la base de datos con la nueva ruta
        $this->jobApplication->update(['cv_path' => $path]);

        // Limpio input
        $this->reset('cv');

        session()->flash('message', 'CV subido correctamente');
    }

    public function deleteCV()
    {
        if ($this->jobApplication->cv_path) {
            Storage::disk('public')->delete($this->jobApplication->cv_path);
            $this->jobApplication->update(['cv_path' => null]);

            session()->flash('message', 'CV eliminado correctamente.');
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string'
        ]);

        $this->jobApplication->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->message
        ]);

        $this->reset('message');
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.job-application-chat');
    }
}
