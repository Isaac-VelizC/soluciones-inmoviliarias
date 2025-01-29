<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\PropiedadesController;
use Modules\Admin\Http\Controllers\UserManagement;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function() {
        //Route::resource('/', AdminController::class)->names('admin');
        Route::get('/', [AdminController::class, 'index'])->name('adm.home');
        //
        Route::get('/propiedades', [PropiedadesController::class, 'index'])->name('adm.propiedades.index');
        Route::get('/propiedades/usuario/{id?}', [PropiedadesController::class, 'usuarios_index'])->name('adm.propiedades.usuarios.index');
        //
        Route::get('/propiedades/agregar', [PropiedadesController::class, 'agregar'])->name('adm.propiedades.agregar');
        Route::post('/propiedades/agregar_nuevo', [PropiedadesController::class, 'agregar_nuevo'])->name('adm.propiedades.agregar_nuevo');
        Route::get('/propiedades/subir_imagenes/{id?}', [PropiedadesController::class, 'pagina_subir_imagenes'])->name('adm.subir.imagenes');
        Route::post('/guardar-hotspot', [ImagenController::class, 'storeHotspot'])->name('guardar.hotspot');
        //
        Route::get('/propiedades/editar/{id}', [PropiedadesController::class, 'editar'])->name('adm.propiedades.editar');
        Route::post('/propiedades/editar_existente/{id?}', [PropiedadesController::class, 'editar_existente'])->name('adm.propiedades.editar_existente');
        Route::post('/propiedades/imagen/store', [ImagenController::class, 'store'])->name('adm.propiedades.imagenes.store');
        Route::get('/propiedades/imagenes/{id}/ver', [ImagenController::class, 'showImage'])->name('adm.propiedades.imagenes.showImage');
        Route::delete('/propiedades/imagen/destroy/{id}', [ImagenController::class, 'destroy'])->name('adm.propiedades.imagenes.destroy');
        //Citas proiedades
        Route::get('/propiedades/citas/{id?}', [PropiedadesController::class, 'citas'])->name('adm.propiedades.citas');
        //
        Route::post('/propiedades/propietario/store', [PropiedadesController::class, 'propietario_agregar'])->name('adm.propiedades.propietario.store');
        Route::get('/propiedades/propietario/show/{id}', [PropiedadesController::class, 'show'])->name('adm.propiedades.show');
        Route::post('/propiedades/tipo/store', [PropiedadesController::class, 'tipo_agregar'])->name('adm.propiedades.tipo.store');
        Route::post('/propiedades/ventatipo/store', [PropiedadesController::class, 'venta_tipo_agregar'])->name('adm.propiedades.ventatipo.store');
        //servicios
        Route::get('/servicios/lista/solicitudes/{id}', [PropiedadesController::class, 'lista_solicitudes'])->name('adm.servicio.solicitud');
        Route::get('/servicios/lista', [ServicioController::class, 'index'])->name('adm.servicios.index');
        Route::get('/servicios/show/{id}', [ServicioController::class, 'show'])->name('adm.servicios.show');
        Route::get('/servicios/seguimiento/{id?}', [ServicioController::class, 'seguimiento'])->name('adm.servicios.seguimiento');
        Route::get('/servicios/lista/ajax', [ServicioController::class, 'ajax_servicios'])->name('adm.servicios.ajax.index');
        Route::get('/servicios/lista/propiedad/{id}', [ServicioController::class, 'ajax_servicios_propiedade'])->name('adm.servicios.ajax.propiedad.list');
        //
        Route::get('/servicios/agregar/{id?}', [ServicioController::class, 'agregar'])->name('adm.servicios.agregar');
        Route::post('/servicios/agregar_nuevo', [ServicioController::class, 'store'])->name('adm.servicios.agregar_nuevo');
        Route::post('/servicios/agregar_imagen', [ServicioController::class, 'store_imagen_servicio'])->name('adm.servicios.agregar_imagen');
        //
        Route::get('/servicios/editar/{id?}', [ServicioController::class, 'edit'])->name('adm.servicios.editar');
        Route::post('/servicios/editar_existente', [ServicioController::class, 'update'])->name('adm.servicios.editar_existente');
        Route::post('/presupuestos/agregar_nuevo', [PresupuestoController::class, 'store'])->name('adm.presupuesto.agregar_nuevo');
        //Route::get('/roles/crear', [PropietarioController::class, 'crear'])->name('adm.roles.crear');
        //
        Route::get('/usuarios/administracion', [UserManagement::class, 'UserManagement'])->name('adm.usuarios.administracion');
        //Propietarios
        Route::get('/propietarios/lista', [PropietarioController::class, 'index'])->name('adm.propietarios.index');
        Route::get('/propietarios/lista/ajax', [PropietarioController::class, 'ajax_propietarios'])->name('adm.propietarios.ajax.index');

        Route::get('/propietarios/create', [PropietarioController::class, 'create'])->name('adm.propietarios.create');
        Route::post('/propietarios/store', [PropietarioController::class, 'store'])->name('adm.propietarios.store');

        Route::get('/propietarios/{id?}/edit', [PropietarioController::class, 'edit'])->name('adm.propietarios.edit');
        Route::post('/propietarios/update', [PropietarioController::class, 'update'])->name('adm.propietarios.update');
        //Citas
        Route::get('/citas/lista', [CitaController::class, 'index_admin'])->name('adm.citas.index');
        Route::get('/citas/usuario/{id?}', [CitaController::class, 'index_admin_user'])->name('adm.citas.usuarios');

        Route::get('/citas/create', [CitaController::class, 'create'])->name('adm.citas.create');
        Route::post('/citas/store', [CitaController::class, 'store'])->name('adm.citas.store');

        Route::get('/citas/{id?}/edit', [CitaController::class, 'edit'])->name('adm.citas.edit');
        Route::put('/citas/update/{id}', [CitaController::class, 'update_admin'])->name('adm.citas.update');

        Route::post('/citas/encuesta', [CitaController::class, 'admin_cita_encuesta'])->name('adm.citas.encuesta');
        Route::get('/citas/encuesta/graficas', [CitaController::class, 'admin_cita_encuesta_graficas'])->name('adm.citas.encuesta.graficas');
    });
});

Route::get('/denegado', function () {
    return  view('web.home.denegado');
})->name('unauthorized');
//Route::group([], function () {
//    Route::resource('admin', AdminController::class)->names('admin');
//});
