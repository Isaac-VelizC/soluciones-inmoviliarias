<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'agente']);
        Role::create(['name' => 'cliente']);
        Permission::create(['name' => 'Administrar Todo']);
        // Asignar permisos al rol admin
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo('Administrar Todo');
        $adminRole = Role::findByName('agente');
        $adminRole->givePermissionTo('Administrar Todo');
        // Asignar rol admin al usuario con ID 1
        $userAdmin = User::find(1);
        if ($userAdmin) {
            $userAdmin->assignRole('admin');
        }
        $userAdmin = User::find(2);
        if ($userAdmin) {
            $userAdmin->assignRole('admin');
        }
    }
}
