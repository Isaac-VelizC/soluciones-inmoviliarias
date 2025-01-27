<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropietarioController extends Controller
{
    //
    public function index()
    {
        $propietarios = Propietario::all();
        return view('admin::propietarios.index', compact('propietarios'));
    }

    public function create()
    {
        return view('admin::propietarios.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/',
            'apellido' => 'required|string|max:100|regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/',
            'email' => 'required|email|max:255|regex:/^[\w\.-]+@[\w\.-]+\.\w+$/',
            'telefono' => 'required|string|min:8|max:10|regex:/^\d+$/',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Propietario::create($request->all());

        return redirect()->route('adm.propietarios.index')->with('success', 'Propietario creado exitosamente.');
    }

    public function edit($id)
    {
        $propietario = Propietario::findOrFail($id);
        return view('admin::propietarios.edit', ['propietario' => $propietario]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/',
            'apellido' => 'required|string|max:100|regex:/^[A-Za-zÑñáéíóúÁÉÍÓÚ ]+$/',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|min:8|max:10|regex:/^\d+$/',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $propietario = Propietario::findOrFail($request->id);
        $propietario->update($request->all());

        return redirect()->route('adm.propietarios.index')->with('success', 'Propietario actualizado exitosamente.');
    }

    public function destroy(Propietario $propietario)
    {
        $propietario->delete();
        return redirect()->route('adm.propietarios.index')->with('success', 'Propietario eliminado exitosamente.');
    }

    public function ajax_propietarios()
    {
        $data = Propietario::all();
        return datatables()
            ->of($data)
            ->addColumn('botones', 'admin::propietarios.actions.index')
            ->rawColumns(['botones'])
            ->toJson();
    }
}
