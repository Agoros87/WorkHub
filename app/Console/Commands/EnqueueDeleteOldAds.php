<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldAdvertisements;
use Illuminate\Console\Command;

class EnqueueDeleteOldAds extends Command
{
    protected $signature = 'ads:enqueue-delete-old {days=35 : Días de antigüedad}';

    protected $description = 'Encola un job para eliminar anuncios antiguos'; // php artisan help comando muestra descripcion

    public function handle()
    {
        $days = (int) $this->argument('days');
        // -- -10
        if ($days <= 0 || $days > 7300) {
            $this->error('El número de días debe ser un valor positivo mayor a 0 y menor que 7300');

            return Command::FAILURE; // devuelve 1 para indicar que ha habido un error
        }
        // dispatchSync() ejecuta el job inmediatamente
        DeleteOldAdvertisements::dispatch($days); // Encola el job
        // En .env QUEUE_CONNECTION=sync para que se ejecute inmediatamente
        $this->info("Job encolado: se eliminarán anuncios de más de {$days} días");

        return Command::SUCCESS;
    }
}
