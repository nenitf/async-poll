<?php

namespace App\Jobs;

use App\Services\CadastroVoto;

class ComputaVotoJob extends Job
{
    public function __construct(
        private int $idOpcao
    ) {}

    public function handle(CadastroVoto $service)
    {
        $service->execute($this->idOpcao);
    }

    public function failed(\Exception $e = null)
    {
        dump($e);
    }
}

