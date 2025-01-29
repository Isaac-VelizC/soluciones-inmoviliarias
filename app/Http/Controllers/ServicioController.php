<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ImagenServicio;
use App\Models\Presupuesto;
use App\Models\Propiedades;
use App\Models\ServiciosTipo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\SolicitudServicio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    public function index()
    {
        $servicio = null;
        return view('admin::servicios.index', ['servicio' => $servicio]);
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        $usuarios = User::with('client')->where('rol', 'cliente')->get();
        $presupuestos = Presupuesto::getByIdServicio($id);
        $propiedad = Propiedades::findOrFail($servicio->id_propiedad);
        $tipoServicio = Serviciostipo::all(); //getAllOrdenPorDescripcion();
        return view('admin::servicios.editar', ['servicio' => $servicio, 'usuarios' => $usuarios, 'presupuestos' => $presupuestos, 'tipoServicio' => $tipoServicio,  'propiedadID' => $propiedad]);
    }
    public function agregar($id)
    {
        $item = Propiedades::findOrFail($id);
        if (!$item) {
            return redirect()->back()->with('error', 'No existe la propiedad');
        }
        $usuarios = User::with('client')->where('rol', 'cliente')->get();
        $tipoServicio = ServiciosTipo::all();
        return view('admin::servicios.agregar', ['usuarios' => $usuarios, 'tipoServicio' => $tipoServicio, 'propiedadID' => $item]);
    }

    public function seguimiento($id)
    {
        $servicio = Servicio::with(['usuario', 'tipoServicio'])->findOrFail($id);
        return view('admin::servicios.seguimiento', ['servicio' => $servicio]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Servicio::$rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $servicios_detalle = implode('|', $request->servicios_detalle);
        $data = $validator->validated();
        $data['servicios_detalle'] = $servicios_detalle;
        Servicio::create($data);

        return redirect()->route('adm.servicios.agregar', $request->id_propiedad)
            ->with('success', 'Servicio guardado exitosamente.');
    }

    public function store_imagen_servicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imagenes.*' => 'required|image|mimes:jpg,png,webp|max:2048',
            'id_servicio' => 'required|integer|exists:servicios,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            // Verifica si hay archivos en la solicitud
            if ($request->hasFile('imagenes')) {
                $imagenes = $request->file('imagenes');
                foreach ($imagenes as $imagen) {
                    // Almacena la imagen en el directorio storage/app/public/imagenes
                    $path = $imagen->store('imagenes', 'public');
                    // Crea un nuevo registro en la base de datos
                    ImagenServicio::create([
                        'imagen' => $path, // Guarda la ruta relativa
                        'id_servicio' => $request->id_servicio,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Imágenes subidas correctamente.');
        } catch (\Throwable $th) {
            Log::error('Error al subir imágenes: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al subir las imágenes.');
        }
    }

    public function solicitar_servicio(Request $request)
    {
        $validatedData = $request->validate([
            "id_propiedad" => "required|integer|exists:propiedades,id",
            "id_usuario" => "required|integer|exists:users,id",
            "tipo_de_servicio" => "required|integer|exists:servicios_tipo,id",
            "servicios_detalle" => "required|array",
            "fecha_fin" => "required|date|after_or_equal:today",
            "descripcion" => "required|string|max:500"
        ]);

        try {
            $servicios_detalle = implode('|', $request->servicios_detalle);
            $validatedData['servicios_detalle'] = $servicios_detalle;
            $validatedData['fecha_inicio'] = Carbon::now();
            SolicitudServicio::create($validatedData);
            return back()->with('success', 'Solicitud enviada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al enviar la solicitud.');
        }
    }

    public function store_cliente(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/'],
            'apellido' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telefono' => ['required', 'string', 'max:255'],
        ]);
        try {
            // Crear el usuario
            $user = User::create([
                'name' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['telefono'],
                'password' => Hash::make('SI.' . $validatedData['telefono']),
            ]);

            // Crear el cliente
            Cliente::create([
                'nombre' => $validatedData['nombre'],
                'apellido' => $validatedData['apellido'],
                'email' => $validatedData['email'],
                'telefono' => $validatedData['telefono'],
                'id_user' => $user->id,
            ]);

            return response()->json([
                'message' => 'Cliente agregado con éxito',
                'ultID' => $user->id,
                'ultNombre' => $request->nombre . ' ' . $request->apellido
            ], 201);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), Servicio::$rulesupdate);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $servicio = Servicio::findOrFail($request->id);
        $servicios_detalle = implode('|', $request->servicios_detalle);
        $servicio->fill($validator->validated());
        $servicio->servicios_detalle = $servicios_detalle;
        $servicio->save(); // Guardar los cambios

        return redirect()->route('adm.servicios.editar', $request->id)
            ->with('success', 'Servicio actualizado exitosamente.');
    }

    public function show($id)
    {
        $servicio = Servicio::with(['usuario.client', 'imagenes', 'tipoServicio'])->find($id);
        if (!$servicio) {
            return redirect()->back()->with('error', 'No se encontró el servicio');
        }
        return view('admin::servicios.show', compact('servicio'));
    }

    public function ajax_servicios()
    {
        $items = Servicio::with(['usuario.client', 'tipoServicio'])->get();

        // Transformar los datos de los servicios
        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'nombre_cliente'      => $item->usuario->client->nombre . ' ' . $item->usuario->client->apellido,
                'tipo_de_servicio'    => $item->tipoServicio->nombre,
                'direccion'           => $item->direccion,
                'fecha_inicio'        => $item->fecha_inicio,
                'estado'              => $item->estado,
            ];
        });

        return datatables()
            ->of($data)
            ->addColumn('botones', 'admin::servicios.actions.index')
            ->rawColumns(['botones'])
            ->toJson();
    }

    public function ajax_servicios_propiedade($id) {

        $items = Servicio::with(['usuario.client', 'tipoServicio'])->where('id_propiedad', $id)->get();

        // Transformar los datos de los servicios
        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'nombre_cliente'      => $item->usuario->client->nombre . ' ' . $item->usuario->client->apellido,
                'tipo_de_servicio'    => $item->tipoServicio->nombre,
                'direccion'           => $item->direccion,
                'fecha_inicio'        => $item->fecha_inicio,
                'estado'              => $item->estado,
            ];
        });

        return datatables()
            ->of($data)
            ->addColumn('botones', 'admin::servicios.actions.index')
            ->rawColumns(['botones'])
            ->toJson();
    }
}
