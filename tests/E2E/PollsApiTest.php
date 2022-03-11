<?php

namespace Tests\E2E;

use App\Models\Enquete;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PollsApiTest extends \Tests\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private static $ep = '/api/polls';

    private function sut()
    {
        return app()->make(CadastroEnquete::class);
    }

    public function testCria()
    {
        $req = [
            'title'     => $this->faker->words(3, true),
            'options'   => [
                [
                    'name' => $this->faker->words(1, true),
                    'order' => 2,
                ],
                [
                    'name' => $this->faker->words(1, true),
                    'order' => 1,
                ],
            ],
        ];

        $this
            ->json('POST', self::$ep, $req)
            ->seeJsonStructure(
                ['data' => ['id', 'title', 'options' => [ ['name', 'order'] ]]
            ])
            ->response
            ->assertCreated();

        $this->seeInDatabase('enquetes', ['titulo' => $req['title']]);
    }

    public function testLista16Com2Paginas()
    {
        $enquetes = Enquete::factory()->count(16)->create();

        $this
            ->json('GET', self::$ep)
            ->seeJsonStructure(['data'])
            ->response
            ->assertOk()
            ->assertJsonCount(10, 'data');

        $this
            ->json('GET', self::$ep.'?page=2')
            ->seeJsonStructure(['data'])
            ->response
            ->assertOk()
            ->assertJsonCount(6, 'data');
    }

    public function testExibePorId()
    {
        $enquetes = Enquete::factory()->count(3)->create();

        $e = $enquetes[1];
        $this
            ->json('GET', self::$ep."/{$e->id}")
            ->seeJsonStructure(['data' => ['id', 'title']])
            ->response
            ->assertOk()
            ->assertJsonFragment(['title' => $e->titulo]);
    }
}

