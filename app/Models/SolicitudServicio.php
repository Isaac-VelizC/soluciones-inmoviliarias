<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudServicio extends Model
{
    use HasFactory;
    protected $table = 'solicitud_servicios';
    
    protected $fillable = [
        'servicios_detalle',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'id_usuario',
        'tipo_de_servicio',
        'id_propiedad',
    ];
    
    public function usuario() {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function tipoServicio() {
        return $this->belongsTo(ServiciosTipo::class, 'tipo_de_servicio');
    }

    public function propiedad() {
        return $this->belongsTo(Propiedades::class, 'id_propiedad');
    }

}
