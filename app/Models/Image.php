<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre', 'tipo', 'imagen', 'id_propiedad'
    ];

    public function propiedad() {
        return $this->belongsTo(Propiedades::class, 'id_propiedad');
    }

    public function hotspots() {
        return $this->hasMany(Hotspot::class, 'sceneId');
    }
    
}
