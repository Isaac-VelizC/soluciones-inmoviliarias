<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;
    protected $table = 'propietarios';
    protected $fillable = ['nombre', 'apellido', 'email', 'telefono'];

    public function propiedades() {
        return $this->hasMany(Propiedades::class, 'id_propietario');
    }
}
