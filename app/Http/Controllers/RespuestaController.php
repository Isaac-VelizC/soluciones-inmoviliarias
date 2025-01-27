<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RespuestaController extends Controller
{
    //
    public function store(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        $datos = $request->all();
        $ne = explode("|", substr($request->encuestas, 0, -1));
        //dd($request);
        // Crear una nueva respuesta con el usuario_id del usuario autenticado
        for($i = 0; $i < count($ne); $i++) {
            Respuesta::create([
                'usuario_id' => $user->id,
                // Otros campos del formulario
                //'pregunta_id' => $request->pregunta_id,
                'cita_id' => $request->cita_id,
                //'respuesta' => $request->respuesta,
                'encuesta_id' => $ne[$i],
                'respuesta_id' => $datos["respuesta_".$ne[$i]]
            ]);
        }
        return redirect()->route('usuario.citas.encuesta', [$request->cita_id, $request->propiedad])->with('success', 'Sus respuestas han sido almacenadas correctamente, gracias.');
    }
}
