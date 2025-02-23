<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldAdvertisements;
use Illuminate\Console\Command;

class EnqueueDeleteOldAds extends Command
{
    protected $signature = 'ads:enqueue-delete-old {days=35 : Días de antigüedad}';
    protected $description = 'Encola un job para eliminar anuncios antiguos';

    public function handle()
    {
        $days = (int) $this->argument('days');

        if ($days <= 0 || $days > 7300) {
            $this->error('El número de días debe ser un valor positivo mayor a 0 y menor que 7300');
            return Command::FAILURE;
        }

        DeleteOldAdvertisements::dispatch($days);

        $this->info("Job encolado: se eliminarán anuncios de más de {$days} días");
        return Command::SUCCESS;
    }
}
