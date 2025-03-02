<?php

namespace App\Jobs;

use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteOldAdvertisements implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $daysOld;

    /**
     * Create a new job instance.
     */
    public function __construct(int $daysOld = 35) // Cuando llamas a la clase, puedes pasar un número de días para eliminar anuncios antiguos
    {
        $this->daysOld = $daysOld;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $date = Carbon::now()->subDays($this->daysOld); // Fecha actual menos los días que le hemos pasado

        // Busca anuncios que tengan una fecha de actualización anterior a la fecha que hemos calculado
        $oldAdvertisements = Advertisement::where('updated_at', '<', $date)->get();

        Log::info("Eliminando {$oldAdvertisements->count()} anuncios antiguos de más de {$this->daysOld} días");

        //Recorre los anuncios y los elimina.
        foreach ($oldAdvertisements as $advertisement) {

            $advertisement->delete();
        }

        Log::info('Proceso de eliminación de anuncios antiguos completado');
    }
}
