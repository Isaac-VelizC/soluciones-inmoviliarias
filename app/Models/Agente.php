<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    protected $table = 'oficinas';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'id_oficina',
        'id_user'
    ];

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'id_oficina');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
