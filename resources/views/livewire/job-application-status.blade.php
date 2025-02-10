<div>
    @if(auth()->id() === $jobApplication->advertisement->user_id)
        <div class="p-4 flex gap-4 justify-end">
            @if($jobApplication->status !== 'accepted')
                <button wire:click="accept" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Aceptar aplicación
                </button>
            @endif
            
            @if($jobApplication->status !== 'rejected')
                <button wire:click="reject" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Rechazar aplicación
                </button>
            @endif
        </div>
    @endif

    @if($jobApplication->status === 'accepted')
        <div class="p-4 bg-green-100 text-green-700">
            Esta aplicación ha sido aceptada
        </div>
    @elseif($jobApplication->status === 'rejected')
        <div class="p-4 bg-red-100 text-red-700">
            Esta aplicación ha sido rechazada
        </div>
    @endif
</div>
