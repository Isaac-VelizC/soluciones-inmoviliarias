<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    public $timestamps = false;
    protected $table = 'oficinas';
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
        'pais'
    ];

    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_oficina');
    }
}
