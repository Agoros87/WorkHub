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
        $this->jobApplication = $jobApplication; //Guarda la instancia de la aplicación de trabajo
        $this->loadMessages(); //Carga los mensajes de la aplicación de trabajo
    }

    public function loadMessages()
    {
        $this->messages = $this->jobApplication->messages()
            ->with('user') //Carga anticipada de el usuario que envió el mensaje
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
    }

    public function uploadCV()
    {
        if (! $this->cv) { //Comprueba si se ha subido un archivo
            session()->flash('error', 'Debes de seleccionar un archivo antes');

            return;
        }

        $this->validateCV(); //Valida el archivo

        $this->deleteOldCV(); //Elimina el archivo anterior si existe

        $path = $this->storeNewCVInDisk(); //Guarda el archivo en el disco
        $this->updateCVPathInDataBase($path); //Actualiza la ruta en la base de datos

        $this->resetCVInput(); //Resetea el input del archivo
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
//Crea un nuevo mensaje en la aplicación de trabajo y lo guarda en el modelo chatmessages con el usuario que lo envió y el mensaje
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
