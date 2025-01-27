<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    use HasFactory;
    protected $table = 'hotspots';
    protected $fillable = [
        'sceneId', 'targetScene', 'pitch', 'yaw', 'propiedad_id', 'nombre'
    ];

    public function propiedad() {
        return $this->belongsTo(Propiedades::class, 'propiedad_id');
    }
    
    public function imagen() {
        return $this->belongsTo(Image::class, 'sceneId');
    }
}
