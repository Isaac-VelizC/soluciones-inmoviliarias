<?php

namespace App\Http\Controllers;

use App\Models\Hotspot;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImagenController extends Controller
{
    public function index()
    {
        $imagenes = Image::all();
        return view('imagenes.index', compact('imagenes'));
    }
    public function showImage($id)
    {
        $imagen = Image::findOrFail($id);
        return response($imagen->imagen)->header('Content-Type', 'image/jpeg');
    }

    public function create()
    {
        return view('imagenes.create');
    }

    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|max:255',
            'imagenes.*' => 'required|image',
            'id_propiedad_img' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            // Procesar las imágenes si existen
            if ($request->hasFile('imagenes')) {
                $imagenes = $request->file('imagenes');
                $tipo = $request->tipo;
                $idPropiedad = $request->id_propiedad_img;
                
                // Guardar todas las imágenes en un solo paso
                foreach ($imagenes as $imagen) {
                    Image::create([
                        'tipo' => $tipo,
                        'imagen' => file_get_contents($imagen), // Considera usar almacenamiento en disco en lugar de base64
                        'id_propiedad' => $idPropiedad,
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Imágenes creadas correctamente.');
        } catch (\Throwable $th) {
            // Manejo de errores más claro
            Log::error('Error al subir imágenes: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al subir las imágenes.');
        }
    }

    public function edit($id)
    {
        $imagen = Image::findOrFail($id);
        return view('imagenes.edit', compact('imagen'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|max:255',
            'imagen' => 'image',
            'id_propiedad' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagen = Image::findOrFail($id);
        $imagen->tipo = $request->tipo;
        if ($request->hasFile('imagen')) {
            $imagen->imagen = file_get_contents($request->file('imagen'));
        }
        $imagen->id_propiedad = $request->id_propiedad;
        $imagen->save();

        return redirect()->route('imagenes.index')->with('success', 'Imagen actualizada correctamente.');
    }
    public function destroy($id)
    {
        $imagen = Image::findOrFail($id);
        $imagen->delete();

        return redirect()->back()->with('success', 'Imagen eliminada correctamente.');
    }

    public function storeHotspot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_hotspot' => 'required|string|max:100|regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/', // Se agrega un límite máximo
            'targetScene' => 'required|integer|exists:images,id',
            'sceneId' => 'required|integer|exists:images,id',
            'propiedad_id' => 'required|integer|exists:propiedades,id', // Corrección de "exist" a "exists"
            'pitch' => 'required|numeric', // Se asegura que sea un número
            'yaw' => 'required|numeric', // Se asegura que sea un número
        ]);
        // Manejo de errores de validación
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            // Crear el hotspot utilizando los datos validados
            $hots = Hotspot::create($validator->validated());
            $hots->nombre = $request->nombre_hotspot;
            $hots->save();
            return back()->with('success', 'Hotspot guardado correctamente.');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            // Manejo de errores en caso de fallo al guardar
            Log::error('Error al guardar el hotspot: ' . $th->getMessage());
            return back()->with('error', 'Ocurrió un error al guardar el hotspot.');
        }
    }
}
