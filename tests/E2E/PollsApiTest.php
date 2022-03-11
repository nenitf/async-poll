<?php

namespace Tests\E2E;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PollsApiTest extends \Tests\TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

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
}

