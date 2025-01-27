<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropiedadesCaracteristica extends Model
{
    protected $table = 'propiedades_caracteristicas';

    protected $fillable = [
        'id_propiedad',
        'id_caracteristica'
    ];

    /*public function propiedad()
    {
        return $this->belongsTo(Oficina::class, 'id_oficina');
    }

    public function caracteristica()
    {
        return $this->belongsTo(User::class, 'id_user');
    }*/
}
