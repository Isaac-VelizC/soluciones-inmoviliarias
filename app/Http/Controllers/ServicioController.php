<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Propiedades;
use App\Models\ServiciosTipo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

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
        //
        $tipoServicio = Serviciostipo::all(); //getAllOrdenPorDescripcion();
        return view('admin::servicios.editar', ['servicio' => $servicio, 'usuarios' => $usuarios, 'presupuestos' => $presupuestos, 'tipoServicio' => $tipoServicio]);
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

    public function store_cliente(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/'],
                'apellido' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'telefono' => ['required', 'string', 'max:255'],
            ]);

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
}
