<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Propiedades;

class HomePage extends Controller
{
    public function index()
    {
        // Obtener todas las propiedades publicitadas
        $propiedades = Propiedades::with('imagenes')->where('publicidad_estado', 'publicitado')
            ->take(5)
            ->get();
        return view('web.home.index', [
            'propiedades' => $propiedades
        ]);
    }
}
