<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mano_de_obra' => 'required|string|max:255',
            'maquinaria' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'precio_total' => 'nullable|numeric',
            'id_servicio' => 'nullable|integer',
        ]);

        Presupuesto::create($request->all());

        return response()->json([
            'message' => 'Propiedad creada con éxito'
        ], 201);
    }
}
