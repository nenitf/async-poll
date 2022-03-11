<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\{
    Enquete,
    Opcao,
};

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ordem = 1;

        Enquete::factory()
            ->count(5)
            ->hasOpcoes(3, function (array $attributes) use(&$ordem) {
                return ['ordem' => $ordem++];
            })
            ->create();
        // $this->call('UsersTableSeeder');
    }
}
