<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropiedadesTipo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'propiedades_tipo';
    protected $fillable = ['descripcion', 'detalle'];

    public function propiedades() {
        return $this->hasMany(Propiedades::class, 'tipo_propiedad');
    }

    public static function getTodo()
    {
        return self::orderBy('descripcion', 'asc')->get();
    }
}
