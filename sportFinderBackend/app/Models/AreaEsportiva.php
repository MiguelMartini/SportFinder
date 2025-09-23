<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaEsportiva extends Model
{
    protected $table = 'areas_esportivas';

    protected $fillable = [
        'id_administrador',
        'titulo',
        'descricao',
        'endereco',
        'cidade',
        'cep',
        'nota',
    ];

    public function administrador()
    {
        return $this->belongsTo(Usuario::class, 'id_administrador');
    }
}
