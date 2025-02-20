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
        $days = $this->argument('days');
        
        DeleteOldAdvertisements::dispatch($days);
        
        $this->info("Job encolado: se eliminarán anuncios de más de {$days} días");
    }
}
