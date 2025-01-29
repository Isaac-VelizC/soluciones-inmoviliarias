<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre_cliente',
        'tipo_de_servicio',
        'direccion',
        'servicios_detalle',
        'nombre_trabajador',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'prueba',
        'precio',
        'id_usuario',
        'id_propiedad',
    ];

    public static $rules = [
        'tipo_de_servicio' => 'required|integer|exists:servicios_tipo,id',
        'direccion' => 'required|string|max:255',
        'servicios_detalle' => 'required|array',
        'nombre_trabajador' => 'required|string|max:100',
        'descripcion' => 'nullable|string',
        'fecha_inicio' => 'required|date|after_or_equal:today',
        'fecha_fin' => 'required|date|after:fecha_inicio',
        'id_usuario' => 'required|integer|exists:users,id',
        "id_propiedad" => 'required|integer|exists:propiedades,id',
        "precio" => "required|numeric|min:1",
        "estado" => "required|string|max:100"
    ];

    public static $rulesupdate = [
        'tipo_de_servicio' => 'required|integer|exists:servicios_tipo,id',
        'direccion' => 'required|string|max:255',
        'servicios_detalle' => 'required|array',
        'nombre_trabajador' => 'required|string|max:100',
        'descripcion' => 'nullable|string',
        'fecha_inicio' => 'required|date|after_or_equal:today',
        'fecha_fin' => 'required|date|after:fecha_inicio',
        'id_usuario' => 'required|integer|exists:users,id',
        "precio" => "required|numeric|min:1",
        "estado" => "required|string|max:100"
    ];

    public function usuario() {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detalle() {
        return $this->belongsTo(ServicioDetalle::class, 'id_servicio');
    }

    public function tipoServicio() {
        return $this->belongsTo(ServiciosTipo::class, 'tipo_de_servicio');
    }

    public function imagenes() {
        return $this->hasMany(ImagenServicio::class, 'id_servicio');
    }

    public function solicitud() {
        return $this->belongsTo(SolicitudServicio::class, '');
    }

    public function propiedad() {
        return $this->belongsTo(Propiedades::class, 'id_propiedad');
    }
}
