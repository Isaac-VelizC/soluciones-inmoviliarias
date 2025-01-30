<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Cita;
use App\Models\Image;
use App\Models\PropiedadesTipo;
use App\Models\VentasTipo;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Hotspot;
use App\Models\Propiedades;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use Illuminate\Support\Facades\Validator;
use App\Models\Propietario;
use App\Models\SolicitudServicio;
use App\Models\Visita;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PropiedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propiedades = Propiedades::with('propietario')->latest()->get();
        return view('admin::propiedades.index', [
            'propiedades' => $propiedades,
            'esDetalle' => false
        ]);
    }

    public function usuarios_index($id)
    {
        $propiedades = Propiedades::where('id_propietario', $id)->get();
        $propietario = Propietario::findOrfail($id);
        return view('admin::propiedades.index', [
            'propiedades' => $propiedades,
            'propietario' => $propietario,
            'esDetalle' => true
        ]);
    }

    public function agregar()
    {
        $propiedad = null;
        $propietarios = Propietario::all();
        $ciudades = $this->obtenerCiudades(); // Llama al método para obtener las ciudades
        $tipopropiedad = PropiedadesTipo::getTodo();
        $ventastipo = VentasTipo::getTodo();

        return view('admin::propiedades.agregar', [
            'propiedad' => $propiedad,
            'propietarios' => $propietarios,
            'ciudades' => $ciudades,
            'tipopropiedad' => $tipopropiedad,
            'ventastipo' => $ventastipo
        ]);
    }

    public function editar($id)
    {
        $imagenes = Image::where('id_propiedad', $id)->get();
        $propietarios = Propietario::all();
        $propiedad = Propiedades::findOrFail($id);
        if (empty($propiedad)) {
            return response()->json([
                'message' => 'Propiedad no encontrada',
            ], 404);
        }
        $ciudades = $this->obtenerCiudades();
        $tipopropiedad = PropiedadesTipo::getTodo();
        $ventastipo = VentasTipo::getTodo();

        return view('admin::propiedades.editar', [
            'propiedad' => $propiedad,
            'imagenes' => $imagenes,
            'propietarios' => $propietarios,
            'ciudades' => $ciudades,
            'tipopropiedad' => $tipopropiedad,
            'ventastipo' => $ventastipo
        ]);
    }

    // Método privado para obtener las ciudades
    private function obtenerCiudades()
    {
        return [
            "La Paz" => [
                "nombre" => "La Paz",
                "coordenadas" => [
                    "latitud" => -16.5,
                    "longitud" => -68.15
                ]
            ],
            "Chuquisaca" => [
                "nombre" => "Sucre",
                "coordenadas" => [
                    "latitud" => -19.03332,
                    "longitud" => -65.26274
                ]
            ],
            "Cochabamba" => [
                "nombre" => "Cochabamba",
                "coordenadas" => [
                    "latitud" => -17.3895,
                    "longitud" => -66.1568
                ]
            ],
            "Santa Cruz" => [
                "nombre" => "Santa Cruz de la Sierra",
                "coordenadas" => [
                    "latitud" => -17.78629,
                    "longitud" => -63.18117
                ]
            ],
            "Oruro" => [
                "nombre" => "Oruro",
                "coordenadas" => [
                    "latitud" => -17.98333,
                    "longitud" => -67.15
                ]
            ],
            "Potosí" => [
                "nombre" => "Potosí",
                "coordenadas" => [
                    "latitud" => -19.58361,
                    "longitud" => -65.75306
                ]
            ],
            "Tarija" => [
                "nombre" => "Tarija",
                "coordenadas" => [
                    "latitud" => -21.53549,
                    "longitud" => -64.72956
                ]
            ],
            "Pando" => [
                "nombre" => "Cobija",
                "coordenadas" => [
                    "latitud" => -11.03333, // Coordenadas aproximadas
                    "longitud" => -68.76667 // Coordenadas aproximadas
                ]
            ],
            "Beni" => [
                "nombre" => "Trinidad",
                "coordenadas" => [
                    "latitud" => -14.83333,
                    "longitud" => -64.9
                ]
            ]
        ];
    }

    public function citas($id)
    {
        $citas = Cita::where('id_propiedad', $id)->get();
        $prodiedad  = Propiedades::findOrFail($id);
        $titulo = "Propiedad: " . $prodiedad->nombre;
        return view('admin::citas.index', ['citas' => $citas, 'id' => $id, 'titulo' => $titulo]);
    }

    public function create()
    {
        return view('admin::create');
    }

    public function agregar_nuevo(Request $request): JsonResponse
    {
        // Validación de datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:250',
            'direccion' => 'required|string|max:200',
            'ciudad' => 'required|string|max:50',
            'tipo_propiedad' => 'required|string|max:50',
            'tipo_traspaso' => 'nullable|string|max:20',
            'num_habitaciones' => 'required|integer|min:0|max:9000',
            'num_dormitorios' => 'required|integer|min:0|max:9000',
            'num_salas' => 'required|integer|min:0|max:9000',
            'num_banos' => 'required|integer|min:0|max:9000',
            'num_cocinas' => 'required|integer|min:0|max:9000',
            'num_garajes' => 'required|integer|min:0|max:9000',
            'superficie_construida' => 'required|numeric|min:0',
            'superficie_terreno' => 'required|numeric|min:1',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:1',
            'moneda' => 'required|string|max:6',
            'financiamiento_bancario' => 'nullable|string|in:Si,No',
            'estatus' => 'required|string|max:50',
            'fecha_listado' => 'required|date|after_or_equal:today',
            'fecha_final' => 'required|date|after_or_equal:fecha_listado',
            'id_propietario' => 'required|integer',
            'latitud' => 'required|string|max:50',
            'longitud' => 'required|string|max:50',
            'publicidad_estado' => 'required|string|max:50'
        ]);

        // Creación de la nueva propiedad
        $nuevoID = Propiedades::create($validatedData);
        $nuevoID->id_user = Auth::user()->id;
        $nuevoID->save();

        return response()->json([
            'message' => 'Propiedad creada con éxito',
            'UltID' => $nuevoID->id
        ], 201);
    }

    public function pagina_subir_imagenes($id)
    {
        $propiedad = Propiedades::findOrFail($id);
        $propietario = Propietario::findOrFail($propiedad->id_propietario);
        $imagenes = Image::where('id_propiedad', $id)->get();
        $imagenes360 = Image::with('hotspots')->where('id_propiedad', $id)->where('tipo', '360')->get();
        $hotspots = Hotspot::all();
        if (empty($propiedad)) {
            return response()->json([
                'message' => 'Propiedad no encontrada',
            ], 404);
        }
        return view('admin::propiedades.agregar_imagenes', [
            'propiedad' => $propiedad,
            'imagenes' => $imagenes,
            'propietario' => $propietario,
            'imagenes360' => $imagenes360,
            'hotspots' => $hotspots
        ]);
    }

    public function editar_existente($id, Request $request): JsonResponse
    {
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:250',
            'direccion' => 'required|string|max:200',
            'ciudad' => 'required|string|max:50',
            'tipo_propiedad' => 'required|string|max:50',
            'tipo_traspaso' => 'nullable|string|max:20',
            'num_habitaciones' => 'required|integer|min:0|max:9000',
            'num_dormitorios' => 'required|integer|min:0|max:9000',
            'num_salas' => 'required|integer|min:0|max:9000',
            'num_banos' => 'required|integer|min:0|max:9000',
            'num_cocinas' => 'required|integer|min:0|max:9000',
            'num_garajes' => 'required|integer|min:0|max:9000',
            'superficie_construida' => 'required|numeric|min:0',
            'superficie_terreno' => 'required|numeric|min:1',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:1',
            'moneda' => 'required|string|max:6',
            'financiamiento_bancario' => 'nullable|string|in:Si,No',
            'estatus' => 'required|string|max:50',
            'fecha_listado' => 'required|date|after_or_equal:today',
            'fecha_final' => 'required|date|after_or_equal:fecha_listado',
            'id_propietario' => 'required|integer',
            'latitud' => 'required|string|max:50',
            'longitud' => 'required|string|max:50',
            'publicidad_estado' => 'required|string|max:50'
        ]);

        try {
            // Actualizar la propiedad utilizando el ID proporcionado
            Propiedades::findOrFail($id)->update($validatedData);

            return response()->json([
                'message' => 'Propiedad actualizada con éxito'
            ], 200);
        } catch (\Throwable $th) {
            // Manejo de errores más claro
            Log::error('Error al actualizar la propiedad con ID ' . $id . ': ' . $th->getMessage());

            return response()->json([
                'error' => 'Ocurrió un error al actualizar la información'
            ], 500);
        }
    }

    public function propietario_agregar(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }
        $nuevoPropietario = Propietario::create($validatedData->validated());
        $nuevoData = Propietario::findOrFail($nuevoPropietario->id);
        return response()->json([
            'message' => 'Propietario agregado con éxito',
            'ultID' => $nuevoData->id,
            'ultNombre' => $nuevoData->nombre . ' ' . $nuevoData->apellido
        ], 201);
    }
    public function tipo_agregar(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:255',
            'detalle' => 'nullable|string|max:300'
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }
        $nuevoPropietario = PropiedadesTipo::create($validatedData->validated());
        $nuevoData = PropiedadesTipo::findOrFail($nuevoPropietario->id);
        return response()->json([
            'message' => 'Tipo de propiedad agregado con éxito',
            'ultID' => $nuevoData->id,
            'ultDescripcion' => $nuevoData->descripcion
        ], 201);
    }
    public function venta_tipo_agregar(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:255',
            'detalle' => 'nullable|string|max:300'
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }
        $nuevoPropietario = VentasTipo::create($validatedData->validated());
        $nuevoData = VentasTipo::findOrFail($nuevoPropietario->id);
        return response()->json([
            'message' => 'Tipo de venta agregado con éxito',
            'ultID' => $nuevoData->id,
            'ultDescripcion' => $nuevoData->descripcion
        ], 201);
    }

    public function show($id)
    {
        $propiedad = Propiedades::with(['propietario', 'imagenes'])->find($id);
        if (!$propiedad) {
            return redirect()->back()->with('error', 'No se encontró la propiedad');
        }
        $imagen360 = Image::with('hotspots')->where('tipo', '360')->where('id_propiedad', $id)->get();
        $visitas = Visita::obtenerTotalVisitas($id);
        $url = url("/propiedades/detalle/{$propiedad->id}");
        $title = $propiedad->nombre;
        $price = number_format($propiedad->precio, 2);
        $message = "🏡 ¡Mira esta propiedad en venta! {$title} por \${$price}. Más detalles aquí: ";
        $shareLinks = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url),
        ];

        $portadaPublic = Image::where('tipo', 'casa_fuera')->where('id_propiedad', $id)->first();

        return view('admin::propiedades.detalle_propiedad', compact('propiedad', 'visitas', 'imagen360', 'shareLinks', 'message', 'portadaPublic'));
    }

    public function edit($id)
    {
        return view('admin::edit');
    }

    public function destroy($id)
    {
        try {
            // Buscar la propiedad y sus relaciones
            $propiedad = Propiedades::with(['imagenes', 'hotspots', 'visitas'])->findOrFail($id);
            Image::where('id_propiedad', $id)->delete();
            Hotspot::where('propiedad_id', $id)->delete();
            Visita::where('propiedad_id', $id)->delete();
            $propiedad->delete();
            // Redirigir con un mensaje de éxito
            return redirect()->route('adm.propiedades.index')->with('success', 'Propiedad eliminada con éxito');
        } catch (\Exception $e) {
            // Manejar excepciones y redirigir con un mensaje de error
            return back()->with('error', 'Ocurrió un error al eliminar la propiedad: ' . $e->getMessage());
        }
    }

    public function lista_solicitudes($id)
    {
        $propiedad = Propiedades::findOrFail($id);
        $lista = SolicitudServicio::with(['tipoServicio', 'usuario.client'])->where('id_propiedad', $id)->latest()->get();
        return view('admin::propiedades.solicitudes', compact('lista', 'propiedad'));
    }
}
