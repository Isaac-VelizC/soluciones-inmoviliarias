<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;
    protected $table = 'encuestas';

    protected $fillable = [
        'nombre',
        'habilitado_hasta',
    ];

    public function preguntas() {
        return $this->hasMany(Pregunta::class, 'encuesta_id');
    }

    public static function encuestasHabilitadasHasta($fecha)
    {
        return self::where('habilitado_hasta', '<=', $fecha)->get();
    }
}
