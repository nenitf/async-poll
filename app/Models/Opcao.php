<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcao extends Model
{
    protected $table = 'opcoes';
    protected $fillable = [ 'nome', 'ordem' ];

    public function Enquete()
    {
        return $this->belongsTo(Enquete::class, 'id', 'id_enquete');
    }
}
