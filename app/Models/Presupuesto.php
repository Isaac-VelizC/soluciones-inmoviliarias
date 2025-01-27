<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;
    protected $table = 'presupuestos';

    protected $fillable = [
        'mano_de_obra',
        'maquinaria',
        'material',
        'precio_total',
        'id_servicio'
    ];

    public static function getByIdServicio($idServicio)
    {
        return self::where('id_servicio', $idServicio)->get();
    }
}
