<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Propiedades;
use Illuminate\Http\Request;

class HomePage extends Controller
{
    public function index()
    {
        // Obtener todas las propiedades publicitadas
        $propiedades = Propiedades::where('publicidad_estado', 'publicitado')
            ->take(5) // Limita el resultado a 5 registros
            ->get();

        // Obtener la última propiedad publicitada
        $ultimaPublicitada = Propiedades::where('publicidad_estado', 'publicitado')
            ->orderBy('fecha_listado', 'desc') // Asegúrate de que 'created_at' sea el campo correcto para determinar la "última"
            ->first();
        // Verificar si existe una última propiedad publicitada
        $imagenes = [];
        if ($ultimaPublicitada) {
            $imagenes = Image::where('id_propiedad', $ultimaPublicitada->id)
                ->where('tipo', '!=', '360')
                ->get();
        }
        
        return view('web.home.index', [
            'propiedades' => $propiedades,
            'ultimaPublicitada' => $ultimaPublicitada,
            'imagenes' => $imagenes
        ]);
    }
}
