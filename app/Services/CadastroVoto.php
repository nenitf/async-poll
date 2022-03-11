<?php

namespace App\Services;

use App\Models\{
    Voto,
    Opcao,
};

class CadastroVoto
{
    public function execute(int $idOpcao): Voto
    {
        Opcao::findOrFail($idOpcao);

        $v = Voto::create([ 'id_opcao' => $idOpcao ]);

        return $v;
    }
}

