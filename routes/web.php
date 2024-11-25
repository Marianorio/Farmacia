<?php

use Illuminate\Support\Facades\Route;

/*-------------------------- INICIO --------------------------*/

Route::get('/', function () {
    return view('welcome');
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
    Route::post('/vista_admin', [VistaAdminController::class, 'store'])->name('admin_user.store');
    Route::get('/vista_admin/{id}/edit', [VistaAdminController::class, 'edit'])->name('admin_user.edit');
    Route::post('/vista_admin/{id}', [VistaAdminController::class, 'update'])->name('admin_user.update');
    Route::delete('/vista_admin/{id}', [VistaAdminController::class, 'destroy'])->name('admin_user.destroy');
});


/*------------------ Vista Ventas ------------------*/ 

use App\Http\Controllers\VentasController;

Route::middleware(['auth'])->group(function () {
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{id}', [VentasController::class, 'show'])->name('ventas.show');
    Route::delete('/ventas/{id}', [VentasController::class, 'destroy'])->name('ventas.destroy');
    Route::get('/ventas/{id}/pdf', [VentasController::class, 'generarPDF'])->name('ventas.pdf');
});