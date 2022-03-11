<?php

namespace Tests\E2E;

use App\Models\Enquete;

use App\Jobs\ComputaVotoJob;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VotesApiTest extends \Tests\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private static $ep = '/api/votes';

    protected function given(string $context, ...$params)
    {
        switch ($context) {
        case 'enquete existente com opcoes':
            $e = Enquete::factory()
                ->hasOpcoes(3)
                ->create();
            return $e;
        }
    }

    public function testCria()
    {
        $e = $this->given('enquete existente com opcoes');

        $req = [ 'optionId' => $e->opcoes[1]->id ];

        $this->expectsJobs(ComputaVotoJob::class);

        $this
            ->json('POST', self::$ep, $req)
            ->response
            ->assertCreated();
    }
}

