<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioDetalle extends Model
{
    use HasFactory;

    protected $table = 'servicios_destalles';

    protected $fillable = [
        'servicio',
        'monto',
        'id_servicio',
    ];

    public function servicio() {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }
}
