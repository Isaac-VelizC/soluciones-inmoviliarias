<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenServicio extends Model
{
    use HasFactory;
    protected $table = 'imagen_servicios';
    protected $fillable = [
        'imagen', 'id_servicio'
    ];

    public function servicio() {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }
}
