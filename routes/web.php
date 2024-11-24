<?php

use Illuminate\Support\Facades\Route;

/*-------------------------- INICIO --------------------------*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

/*-------------------------- VISTAS --------------------------*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/perfil', function () {
    return view('perfil');
})->name('perfil');

Route::get('/vista_admin', function () {
    return view('vista_admin');
})->name('vista_admin');

/*Route::get('/productos', function () {
    return view('productos.productos');
})->name('productos');
*/
Route::get('/recetas', function () {
    return view('recetas.recetas');
})->name('recetas');

Route::get('/obras_sociales', function () {
    return view('obras_sociales.obras_sociales');
})->name('obras_sociales');

Route::get('/proveedores', function () {
    return view('proveedores.proveedores');
})->name('proveedores');

Route::get('/ventas', function () {
    return view('ventas.ventas');
})->name('ventas');

/*-------------------------- LABELS --------------------------*/

Route::get('/roles', function () {
    return view('roles.roles');
})->name('roles');

Route::get('/reportes', function () {
    return view('reportes.reportes');
})->name('reportes');

Route::get('/info', function () {
    return view('info.info');
})->name('info');
/*
Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'productos'])->name('productos');
*/

use App\Http\Controllers\ProductoController;

Route::resource('productos', ProductoController::class);

Route::get('/productos/{producto}/coberturas', [ProductoController::class, 'getCoberturas']);
Route::post('/productos/{producto}/coberturas', [ProductoController::class, 'agregarCobertura']);
Route::delete('/productos/{producto}/coberturas/{obraSocial}', [ProductoController::class, 'eliminarCobertura']);

/*------------------ Usuario Sesion Vista ------------------*/ 

use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'index'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'update'])->name('user.update');
});

/*------------------ Vista Admin ------------------*/ 

use App\Http\Controllers\VistaAdminController;

Route::middleware(['auth'])->group(function () {
    Route::get('/vista_admin', [VistaAdminController::class, 'index'])->name('vista_admin');
    Route::get('/vista_admin/{id}/edit', [VistaAdminController::class, 'edit'])->name('admin_user.edit');
    Route::post('/vista_admin/{id}', [VistaAdminController::class, 'update'])->name('admin_user.update');
    Route::delete('/vista_admin/{id}', [VistaAdminController::class, 'destroy'])->name('admin_user.destroy');
});

use App\Http\Controllers\ObraSocialController;

Route::get('/obras-sociales/data', [ObraSocialController::class, 'getData'])->name('obras-sociales.data');
Route::get('/obras-sociales', [ObraSocialController::class, 'index'])->name('obras-sociales.index');
Route::post('/obras-sociales', [ObraSocialController::class, 'store'])->name('obras-sociales.store');
Route::get('/obras-sociales/{id}', [ObraSocialController::class, 'show'])->name('obras-sociales.show');
Route::put('/obras-sociales/{id}', [ObraSocialController::class, 'update'])->name('obras-sociales.update');
Route::delete('/obras-sociales/{id}', [ObraSocialController::class, 'destroy'])->name('obras-sociales.destroy');
Route::get('/obras-sociales/{id}/productos', [ObraSocialController::class, 'getProductos'])->name('obras-sociales.productos');
Route::post('/obras-sociales/verificar-cuit', [ObraSocialController::class, 'verificarCuit'])
    ->name('obras-sociales.verificar-cuit');

use App\Http\Controllers\CategoriaController;

Route::get('/categorias', [CategoriaController::class, 'index']);

Route::get('/obras-sociales', function() {
    return App\Models\ObraSocial::all();
});

