<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'preguntas';

    protected $fillable = [
        'pregunta',
        'encuesta_id',
    ];

    public function encuesta() {
        return $this->belongsTo(Encuesta::class, 'encuesta_id');
    }

    public static function preguntasPorEncuesta($encuestaId)
    {
        return self::where('encuesta_id', $encuestaId)->get();
    }
//    public static function obtenerPreguntasPorEncuesta($encuestaId){
//        $resultados = DB::select("SELECT
//                      `preguntas`.`pregunta`
//                    FROM
//                      `preguntas`
//                    WHERE
//                      `preguntas`.`encuesta_id` = $encuestaId
//                    ORDER BY
//                      `preguntas`.`id`");
//        return $resultados;
//    }
}
