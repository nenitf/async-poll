<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opcao extends Model
{
    use HasFactory;

    protected $table = 'opcoes';
    protected $fillable = [ 'nome', 'ordem' ];

    public function Enquete()
    {
        return $this->belongsTo(Enquete::class, 'id', 'id_enquete');
    }
}
