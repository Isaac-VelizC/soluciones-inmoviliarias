<?php

namespace Database\Seeders;

use App\Models\Oficina;
use App\Models\PropiedadesTipo;
use App\Models\User;
use App\Models\VentasTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Oficina::create([
            'nombre' => 'Oficina Central',
            'direccion' => 'Potosí, calle Padilla Nº66, zona central',
            'ciudad' => 'Potosí',
            'estado' => 'Tomas Frias',
            'codigo_postal' => '0000',
            'pais' => 'Bolivia'
        ]);        
        
        PropiedadesTipo::create([
            'descripcion' => 'Casa',
            'detalle' => 'Vivienda unifamiliar que ofrece espacios para vivir, como dormitorios, cocina y sala de estar.'
        ]);

        PropiedadesTipo::create([
            'descripcion' => 'Departamento',
            'detalle' => 'Unidad habitacional ubicada dentro de un edificio que comparte áreas comunes.'
        ]);

        PropiedadesTipo::create([
            'descripcion' => 'Local Comercial',
            'detalle' => 'Espacio destinado a actividades comerciales, como tiendas o restaurantes.'
        ]);

        PropiedadesTipo::create([
            'descripcion' => 'Oficina',
            'detalle' => 'Inmueble destinado a actividades administrativas o profesionales.'
        ]);

        PropiedadesTipo::create([
            'descripcion' => 'Terreno',
            'detalle' => 'Extensión de tierra sin edificar, que puede ser utilizada para construcción futura.'
        ]);
        
        VentasTipo::create([
            'descripcion' => 'Venta Directa',
            'detalle' => 'Transacción en la que el comprador adquiere la propiedad directamente del vendedor sin intermediarios.'
        ]);

        VentasTipo::create([
            'descripcion' => 'Venta en Contado',
            'detalle' => 'Transacción donde el comprador paga el total del precio de la propiedad al momento de la compra.'
        ]);

        VentasTipo::create([
            'descripcion' => 'Venta en Remate',
            'detalle' => 'Venta de una propiedad a través de un proceso de subasta, generalmente debido a impagos.'
        ]);
        
        User::create([
            'name' => 'Rachel Starr',
            'email' => 'isa.veliz@gmail.com',
            'password' => bcrypt('IsaacVelizAdmin'),
            'phone' => '43648545',
            'rol' => 'admin'
        ]);

        User::create([
            'name' => 'Maria',
            'email' => 'maria@gmail.com',
            'password' => bcrypt('MariaAdmin'),
            'phone' => '39857394',
            'rol' => 'admin'
        ]);
    }
}
