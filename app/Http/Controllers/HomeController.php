<?php

namespace App\Http\Controllers;

use Jorenvh\Share\Share;

class HomeController extends Controller
{
    public function pagina_nosotros() {
        return view('web.home.page_about');
    }

    public function index($id)
    {
        $share = new Share();
        $shareButtons = $share->page(
            'https://tusitio.com/articulo', // URL que se compartirá
            'Título del artículo' // Título del contenido compartido
        )
        ->facebook();

        return view('socialshare', compact('shareButtons'));
    }
    
}
