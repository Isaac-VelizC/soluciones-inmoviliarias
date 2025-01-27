<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccione extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'fecha_venta', 'precio_venta', 'id_propiedad', 'id_comprador', 'id_vendedor'
    ];

    public function propiedad() {
        return $this->belongsTo(Propiedades::class, 'id_propiedad');
    }

    public function comprador()
    {
        return $this->belongsTo(Cliente::class, 'id_comprador');
    }
    
    public function vendedor()
    {
        return $this->belongsTo(Cliente::class, 'id_vendedor');
    }
}
