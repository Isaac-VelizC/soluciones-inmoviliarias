<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentasTipo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ventas_tipo';
    protected $fillable = ['descripcion', 'detalle'];
    public static function getTodo()
    {
        return self::orderBy('descripcion', 'asc')->get();
    }

    
    public function propiedades() {
        return $this->hasMany(Propiedades::class, 'tipo_traspaso');
    }
}
