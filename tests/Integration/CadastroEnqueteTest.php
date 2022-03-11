<?php

namespace Tests\Integration;

use App\Services\CadastroEnquete;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CadastroEnqueteTest extends \Tests\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private function sut()
    {
        return app()->make(CadastroEnquete::class);
    }

    public function testCadastraNovaEnqueteCom2Opcoes()
    {
        $titulo = $this->faker->words(3, true);
        $opcoes = [
            [
                'nome' => $this->faker->words(1, true),
                'ordem' => 2,
            ],
            [
                'nome' => $this->faker->words(1, true),
                'ordem' => 1,
            ],
        ];

        $e = $this->sut()->execute(
            titulo: $titulo,
            opcoes: $opcoes,
        );

        $this->assertEquals($e->titulo, $titulo);

        $this->seeInDatabase('enquetes', ['titulo' => $titulo]);
        $this->seeInDatabase('opcoes', [
            'id_enquete' => $e->id,
            'nome'       => $opcoes[0]['nome'],
            'ordem'      => $opcoes[0]['ordem'],
        ]);
        $this->seeInDatabase('opcoes', [
            'id_enquete' => $e->id,
            'nome'       => $opcoes[1]['nome'],
            'ordem'      => $opcoes[1]['ordem'],
        ]);
    }
}
