<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiciosTipo extends Model
{
    use HasFactory;
    protected $table = 'servicios_tipo';
    protected $fillable = ['nombre', 'detalle'];

    public static function getAllOrdenPorDescripcion()
    {
        return self::orderBy('nombre', 'asc')->get();
    }

    public function servicios() {
        return $this->hasMany(Servicio::class, 'tipo_de_servicio');
    }
}
