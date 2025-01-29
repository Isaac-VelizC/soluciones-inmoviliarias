<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PropiedadesController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\HomeController;
//use App\Http\Controllers\HomeController;
use Modules\Admin\Http\Controllers\UserManagement;

// Main Page Route
Route::get('/', [HomePage::class, 'index'])->name('pages-home');
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
//Propiedades
Route::get('/propiedades', [PropiedadesController::class, 'index'])->name('propiedades.index');
Route::get('/propiedades/buscar', [PropiedadesController::class, 'buscar'])->name('propiedades.buscar');
Route::get('/propiedades/detalle/{id?}', [PropiedadesController::class, 'detalle'])->name('propiedades.detalle');
Route::get('/propiedades/panorama/{id?}', [PropiedadesController::class, 'panorama'])->name('propiedades.panorama');

Route::resource('/user-list', UserManagement::class);

Route::get('/propiedades/imagenes/{id}/ver', [ImagenController::class, 'showImage'])->name('propiedades.imagenes.ver');

Route::middleware(['auth'])->group(function () {
    Route::get('/usuario', [CitaController::class, 'usuario'])->name('usuario.index');
    Route::get('/usuario/servicios', [CitaController::class, 'servicios'])->name('usuario.servicios.index');
    Route::get('/usuario/servicios/{id}', [CitaController::class, 'serviciosPorPropiedad'])->name('usuario.servicios.index.propiedad');
    Route::post('/usuario/servicios/solicitud/store/', [ServicioController::class, 'solicitar_servicio'])->name('citas.servicios.solicitud.store');
    Route::post('/usuario/servicios/store', [ServicioController::class, 'store_cliente'])->name('citas.servicios.cliente.store');

    Route::get('/usuario/citas/todos', [CitaController::class, 'all_citas_user'])->name('all.citas.user');
    Route::get('/usuario/citas/ver/{id?}/{mes?}/{dia?}/', [CitaController::class, 'index'])->name('usuario.citas.index');
    Route::post('/usuario/citas/agregar_nuevo', [CitaController::class, 'store'])->name('usuario.citas.agregar_nuevo');

    Route::get('/usuario/citas/encuesta/{id?}/{idp?}', [CitaController::class, 'encuesta'])->name('usuario.citas.encuesta');
    Route::post('/usuario/citas/encuesta_respuesta', [RespuestaController::class, 'store'])->name('usuario.citas.encuesta_respuesta');
});

Route::get('/nosotros', [HomeController::class, 'pagina_nosotros'])->name('nosotros.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
