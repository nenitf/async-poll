<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquete extends Model
{
    protected $table = 'enquetes';

    public function opcoes()
    {
        return $this->hasMany(Opcao::class, 'id_enquete');
    }
}
