<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Agent;
use Laravel\Scout\Searchable;

class Propiedades extends Model
{
    use HasFactory, Searchable;
    protected $table = 'propiedades';
    protected $fillable = [
        'nombre', 'direccion', 'ciudad', 'estado', 'tipo_propiedad', 'tipo_traspaso',
        'num_habitaciones', 'num_cocinas', 'num_dormitorios', 'num_salas', 'num_banos',
        'num_garajes', 'superficie_construida', 'superficie_terreno', 'financiamiento_bancario',
        'descripcion', 'precio', 'moneda', 'estatus', 'fecha_listado', 'fecha_final',
        'id_propietario','latitud','longitud', 'id_user', 'publicidad_estado'
    ];
    
    public function tipoPropiedad() {
        return $this->belongsTo(PropiedadesTipo::class, 'tipo_propiedad');
    }
    
    public function tipoVenta() {
        return $this->belongsTo(VentasTipo::class, 'tipo_traspaso');
    }

    public function propietario() {
        return $this->belongsTo(Propietario::class, 'id_propietario');
    }

    public function user() {
        return $this->belongsTo(Agente::class, 'id_user');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        // Customize array as needed
        return $array;
    }
    public static function publicitadas()
    {
        return self::where('publicidad_estado', 'publicitado')->take(4)->get();
    }
    
    public function imagenes() {
        return $this->hasMany(Image::class, 'id_propiedad');
    }

    public function visitas() {
        return $this->belongsTo(Visita::class, 'id_propiedad');
    }

    public function hotspots() {
        return $this->hasMany(Hotspot::class, 'propiedad_id');
    }
    
}
