<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enquete extends Model
{
    use HasFactory;

    protected $table = 'enquetes';

    public function opcoes()
    {
        return $this->hasMany(Opcao::class, 'id_enquete');
    }
}
