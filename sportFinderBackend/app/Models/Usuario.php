<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
      use HasApiTokens;
    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'perfil',
        'documento'
    ];

    public function areaEsportiva(){
        return $this->hasMany(AreaEsportiva::class, 'id_administrador');
    }
}
