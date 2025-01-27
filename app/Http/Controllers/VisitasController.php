<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;

class VisitasController extends Controller
{
    //
    public function registrarVisita($propiedadId)
    {
        $ip = request()->ip();

        // Verificar si la misma IP ha visitado en la última hora
        $ultimaVisita = Visita::where('propiedad_id', $propiedadId)
            ->where('ip_visitante', $ip)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$ultimaVisita || $ultimaVisita->created_at->diffInHours(now()) >= 1) {
            Visita::create([
                'propiedad_id' => $propiedadId,
                'ip_visitante' => $ip,
            ]);
        }
    }

    public function obtenerVisitasPropiedad($propiedadId)
    {
        $visitas = Visita::where('propiedad_id', $propiedadId)->count();
        return response()->json(['visitas' => $visitas]);
    }
}
