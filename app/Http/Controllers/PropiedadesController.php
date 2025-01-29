<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Propiedades;
use App\Models\PropiedadesTipo;
use App\Models\Visita;
use Illuminate\Http\Request;
use Jorenvh\Share\Share;

class PropiedadesController extends Controller
{
    private function ciudadesBolivia()
    {
        return [
            "La Paz" => "La Paz",
            "Chuquisaca" => "Sucre",
            "Cochabamba" => "Cochabamba",
            "Santa Cruz" => "Santa Cruz de la Sierra",
            "Oruro" => "Oruro",
            "Potosí" => "Potosí",
            "Tarija" => "Tarija",
            "Pando" => "Cobija",
            "Beni" => "Trinidad"
        ];
    }
    public function index()
    {
        $tipos = PropiedadesTipo::all();
        $ciudades = $this->ciudadesBolivia();
        $propiedades = Propiedades::with('tipoPropiedad')->where('estatus', 'Disponible')->latest()->get();
        return view('web.home.propiedades', ['propiedades' => $propiedades, 'tipos' => $tipos, 'ciudades' => $ciudades]);
    }
    public function detalle(Request $request, $id)
    {

        $imagenes = Image::where('id_propiedad', $id)->where('tipo', '<>', '360')->get();
        $imagenCasa = Image::where('id_propiedad', $id)->where('tipo', 'casa_fuera')->first();
        $imagen360 = Image::with('hotspots')->where('id_propiedad', $id)->where('tipo', '=', '360')->get();
        $propiedad = Propiedades::with('tipoPropiedad')->findOrFail($id);
        //Contar visitas
        $ip = $request->ip();
        $url = url("/propiedades/detalle/{$propiedad->id}");
        $title = 'Hola mundo';
        $price = number_format($propiedad->precio, 2);
        $message = "🏡 ¡Mira esta propiedad en venta! {$title} por \${$price}. Más detalles aquí: ";

        $shareLinks = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url),
        ];
        // Registrar visita
        Visita::registrarVisita($id, $ip);
        return view('web.home.propiedades_detalle', [
            'propiedad' => $propiedad,
            'imagenes' => $imagenes,
            'imagen360' => $imagen360,
            'imagenCasa' => $imagenCasa,
            'shareLinks' => $shareLinks
        ]);
    }

    public function panorama($id)
    {
        $propiedad = Propiedades::getPropiedad($id)[0];
        return view('web.home.panorama', ['propiedad' => $propiedad]);
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $tipoId = $request->input('tipo_id');
        $ciudad = $request->input('ciudad');

        // Realiza la consulta a la base de datos según los filtros
        $propiedades = Propiedades::when($query, function ($q) use ($query) {
            return $q->where('nombre', 'LIKE', "%{$query}%");
        })
            ->when($tipoId, function ($q) use ($tipoId) {
                return $q->where('tipo_propiedad', $tipoId);
            })
            ->when($ciudad, function ($q) use ($ciudad) {
                return $q->where('ciudad', $ciudad);
            })
            ->get();

        $tipos = PropiedadesTipo::all();
        $ciudades = $this->ciudadesBolivia();
        // Retorna una vista parcial con los resultados
        return view('web.home.propiedades', ['propiedades' => $propiedades, 'tipos' => $tipos, 'ciudades' => $ciudades]);
    }
}
