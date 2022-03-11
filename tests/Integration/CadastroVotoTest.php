<?php

namespace Tests\Integration;

use App\Services\CadastroVoto;

use App\Models\Enquete;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CadastroVotoTest extends \Tests\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private function sut()
    {
        return app()->make(CadastroVoto::class);
    }

    public function testCadastraVoto()
    {
        $e = Enquete::create(['titulo' => $this->faker->words(3, true)]);
        $e->opcoes()->createMany([
            [
                'nome' => $this->faker->words(1, true),
                'ordem' => 2,
            ],
            [
                'nome' => $this->faker->words(1, true),
                'ordem' => 1,
            ]
        ]);

        $idOpcao = $e->opcoes[1]->id;

        $v = $this->sut()->execute($idOpcao);

        $this->assertCount(0, $e->opcoes[0]->votos);
        $this->assertCount(1, $e->opcoes[1]->votos);

        $this->seeInDatabase('votos', [
            'id' => $v->id,
            'id_opcao' => $v->opcao->id,
        ]);
    }
}

