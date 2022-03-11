<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    protected $faker;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $this->faker = \Faker\Factory::create('pt_BR');

        return require __DIR__.'/../bootstrap/app.php';
    }

    public function select(string $query, bool $dd = false)
    {
        if($dd) {
            dd(DB::select($query));
        }
        dump(DB::select($query));
    }
}
