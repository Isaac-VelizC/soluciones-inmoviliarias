<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;
    protected $table = 'visitas';
    protected $fillable = [
        'propiedad_id',
        'ip_visitante',
    ];

    public function propiedad() {
        return $this->belongsTo(Propiedades::class, 'propiedad_id');
    }

    public static function registrarVisita(int $propiedadId, string $ip): bool
    {
        // Verificar si existe una visita en la última hora
        $existeVisita = self::where('propiedad_id', $propiedadId)
            ->where('ip_visitante', $ip)
            ->where('created_at', '>=', now()->subHour())
            ->exists();

        // Si no existe, registrar una nueva visita
        if (!$existeVisita) {
            self::create([
                'propiedad_id' => $propiedadId,
                'ip_visitante' => $ip,
            ]);
            return true;
        }

        return false;
    }

    public static function obtenerTotalVisitas(int $propiedadId): int
    {
        return self::where('propiedad_id', $propiedadId)->count();
    }
}
