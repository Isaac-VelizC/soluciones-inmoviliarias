<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Respuesta extends Model
{
    use HasFactory;
    protected $table = 'respuestas';
    protected $fillable = ['usuario_id', 'cita_id', 'encuesta_id', 'respuesta_id'];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'respuesta_id');
    }

    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class, 'encuesta_id');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function cita() {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public static function obtenerRespuestasPorCita(int $citaId)
    {
        return static::where('cita_id', $citaId)
            ->with('pregunta.encuesta')
            ->get();
    }
    public static function obtenerRespuestasPorPregunta($fecha, $preguntaId){
        $resultados = DB::select("SELECT
                      CONCAT(COALESCE(COUNT(`r`.`id`), 0)) AS `resultado`
                    FROM
                      `respuestas` `r`
                    WHERE
                      `r`.`respuesta_id` = $preguntaId
                      AND DATE_FORMAT(r.created_at, '%Y-%m') = '$fecha'
                    GROUP BY
                      r.id");
        return $resultados;
    }
    public static function obtenerRespuestasAgrupadas($fecha, $encuestaId){
        list($anio, $mes) = explode('-', $fecha);
//        $results = DB::table('respuestas')
//            ->join('preguntas', 'respuestas.respuesta_id', '=', 'preguntas.id')
//            ->selectRaw("preguntas.pregunta, COUNT(respuestas.id) as total")
//            ->whereRaw("DATE_FORMAT(respuestas.created_at, '%Y-%m') = ?", [$fecha])
//            ->whereRaw("preguntas.encuesta_id = ?", [$encuestaId])
//            ->groupBy('preguntas.pregunta')
//            ->get();
//
//        $formattedResults = $results->map(function ($item, $index) {
//            return $item->pregunta . ":" . $item->total;
//        });
//        return $formattedResults;

        $resultados = DB::select("
            SELECT
                p.pregunta AS nombre_pregunta,
                CONCAT('Pregunta ', p.id, ': ', COALESCE(COUNT(r.id), 0), ' veces') AS resultado
            FROM preguntas p
            RIGHT JOIN respuestas r ON p.id = r.respuesta_id
                AND DATE_FORMAT(r.created_at, '%Y-%m') = :fecha
            WHERE r.encuesta_id = $encuestaId
            GROUP BY p.id, p.pregunta
        ", [
            'fecha' => "{$anio}-{$mes}"
        ]);
        return $resultados;
    }
}
