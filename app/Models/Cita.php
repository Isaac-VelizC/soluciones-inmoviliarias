<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas';
    protected $fillable = [
        'fecha',
        'fecha_de_cita',
        'hora_de_cita',
        'estado',
        'anotaciones',
        'id_propiedad',
        'usuario_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function propiedad() {
        return $this->belongsTo(Propiedades::class, 'id_propiedad');
    }

    
    public static function getCitasByPropiedad2($id)
    {
        return DB::select(
            'SELECT *
             FROM citas
             INNER JOIN propiedades ON citas.id_propiedad = propiedades.id
             INNER JOIN users ON citas.id_usuario = users.id
             WHERE propiedades.id = :propiedadId
             ORDER BY citas.fecha_de_cita DESC,
             citas.hora_de_cita DESC',
            ['propiedadId' => $id]
        );
    }
    public static function getCitasControlByPropiedad($id)
    {
        return DB::select(
            'SELECT *
             FROM citas
             INNER JOIN propiedades ON citas.id_propiedad = propiedades.id
             INNER JOIN users ON citas.usuario_id = users.id
             WHERE propiedades.id = :propiedadId
             AND citas.estado = :estado',
            ['propiedadId' => $id, 'estado' => 'pendiente']
        );
    }

    public static function getCitasEdit($id)
    {
        return DB::select(
            'SELECT
                  `propiedades`.`nombre`,
                  `propiedades`.`direccion`,
                  `propiedades`.`id` as propiedad_id,
                  `citas`.`id`,
                  `citas`.`id_usuario`,
                  `citas`.`id_propiedad`,
                  `citas`.`fecha_de_cita`,
                  `citas`.`hora_de_cita`,
                  `citas`.`anotaciones`,
                  `citas`.`estado`,
                  `citas`.`created_at`,
                  `citas`.`updated_at`,
                  `users`.`id` as user_id,
                  `users`.`name`,
                  `users`.`email`,
                  `users`.`phone`
                FROM
                  `citas`
                  INNER JOIN `propiedades` ON (`citas`.`id_propiedad` = `propiedades`.`id`)
                  INNER JOIN `users` ON (`citas`.`id_usuario` = `users`.`id`)
                  WHERE citas.id = :citaId',
            ['citaId' => $id]
        );
    }
    public static function controlHora($sFecha, $sHora){
        return DB::select('SELECT * from citas WHERE fecha_de_cita = :fecha AND hora_de_cita = :hora ', ['fecha' => $sFecha, 'hora' => $sHora]);
    }
}
