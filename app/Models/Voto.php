<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $table = 'votos';
    protected $fillable = [ 'id_opcao' ];

    public function opcao()
    {
        return $this->belongsTo(Opcao::class, 'id_opcao');
    }
}

