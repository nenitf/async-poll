<?php

namespace App\Services;

use App\Models\{
    Enquete,
    Opcao,
};

class CadastroEnquete
{
    public function execute(string $titulo, array $opcoes): Enquete
    {
        $e = new Enquete;
        $e->titulo = $titulo;

        $e->save();

        $opcoes = array_map(function($o) {
            $opcao = new Opcao;
            foreach($o as $p => $v) {
                switch($p) {
                    case 'ordem':
                    case 'nome':
                    $opcao->$p = $v;
                    break;
                default:
                    throw new \InvalidArgumentException();
                }
            }
            return $opcao;
        }, $opcoes);

        $e->opcoes()->saveMany($opcoes);

        return $e;
    }
}

