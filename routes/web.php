<?php

use Illuminate\Support\Facades\Route;

/*-------------------------- INICIO --------------------------*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*-------------------------- VISTAS --------------------------*/

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home')
        ->middleware('permission:home');

    Route::get('/perfil', [App\Http\Controllers\UserController::class, 'index'])
        ->name('perfil')
        ->middleware('permission:perfil');

    Route::get('/vista_admin', [App\Http\Controllers\VistaAdminController::class, 'index'])
        ->name('vista_admin')
        ->middleware('permission:vista_admin');

    Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index'])
        ->name('productos')
        ->middleware('permission:productos.ver');

    Route::resource('productos', App\Http\Controllers\ProductoController::class)
        ->except(['index'])
        ->middleware('permission:productos.gestionar');

    Route::get('/recetas', [App\Http\Controllers\RecetasController::class, 'index'])
        ->name('recetas')
        ->middleware('permission:recetas');

    Route::get('/obras_sociales', [App\Http\Controllers\ObrasSocialesController::class, 'index'])
        ->name('obras_sociales')
        ->middleware('permission:obras_sociales');

    Route::get('/proveedores', [App\Http\Controllers\ProveedoresController::class, 'index'])
        ->name('proveedores')
        ->middleware('permission:proveedores');

    Route::get('/ventas', [App\Http\Controllers\VentasController::class, 'index'])
        ->name('ventas')
        ->middleware('permission:ventas');

    Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])
        ->name('roles')
        ->middleware('permission:roles');

    Route::get('/reportes', [App\Http\Controllers\ReportesController::class, 'index'])
        ->name('reportes')
        ->middleware('permission:reportes');

    Route::get('/info', [App\Http\Controllers\InfoController::class, 'index'])
        ->name('info')
        ->middleware('permission:info');
});

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