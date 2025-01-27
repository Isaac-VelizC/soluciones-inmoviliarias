<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function pagina_nosotros() {
        return view('web.home.page_about');
    }
    public function index() {
        try {
            // Iniciar una transacción
            DB::beginTransaction();
    
            // Crear rol 'admin' si no existe
            if (!Role::where('name', 'admin')->exists()) {
                Role::create(['name' => 'admin']);
            }
    
            // Crear permiso 'Administrar Todo' si no existe
            if (!Permission::where('name', 'Administrar Todo')->exists()) {
                Permission::create(['name' => 'Administrar Todo']);
            }
    
            // Asignar permisos al rol admin
            $adminRole = Role::findByName('admin');
            $adminRole->givePermissionTo('Administrar Todo');
    
            // Asignar rol admin al usuario con ID 1
            $userAdmin = User::find(1);
            if ($userAdmin) {
                $userAdmin->assignRole('admin');
            } else {
                throw new \Exception("Usuario no encontrado.");
            }
    
            // Confirmar la transacción
            DB::commit();
        } catch (\Throwable $th) {
            // Deshacer la transacción en caso de error
            DB::rollBack();
            
            // Manejo del error (puedes registrar el error o mostrar un mensaje)
            //Log::error($th->getMessage());
            
            return response()->json(['error' => 'Error al asignar roles y permisos.'], 500);
        }
    }
    
}
