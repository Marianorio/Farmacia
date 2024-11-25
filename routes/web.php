<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RecetasController;
use App\Http\Controllers\ObrasSocialesController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\VistaAdminController;

/*-------------------------- INICIO --------------------------*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*-------------------------- RUTAS PROTEGIDAS --------------------------*/
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home')
        ->middleware('can:home');

    // Perfil de Usuario
    Route::get('/perfil', [UserController::class, 'index'])
        ->name('perfil')
        ->middleware('can:perfil');
    Route::get('/profile', [UserController::class, 'index'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'update'])->name('user.update');

    // Administración
    Route::prefix('vista_admin')->group(function () {
        Route::get('/', [VistaAdminController::class, 'index'])
            ->name('vista_admin')
            ->middleware('can:vista_admin');
        Route::post('/', [VistaAdminController::class, 'store'])->name('admin_user.store');
        Route::get('/{id}/edit', [VistaAdminController::class, 'edit'])->name('admin_user.edit');
        Route::post('/{id}', [VistaAdminController::class, 'update'])->name('admin_user.update');
        Route::delete('/{id}', [VistaAdminController::class, 'destroy'])->name('admin_user.destroy');
    });

    // Productos
    Route::get('/productos', [ProductoController::class, 'index'])
        ->name('productos')
        ->middleware('can:productos');
    Route::resource('productos', ProductoController::class)
        ->except(['index'])
        ->middleware('can:productos');

    // Ventas
    Route::prefix('ventas')->group(function () {
        Route::get('/', [VentasController::class, 'index'])->name('ventas.index');
        Route::post('/', [VentasController::class, 'store'])->name('ventas.store');
        Route::get('/{id}', [VentasController::class, 'show'])->name('ventas.show');
        Route::delete('/{id}', [VentasController::class, 'destroy'])->name('ventas.destroy');
        Route::get('/{id}/pdf', [VentasController::class, 'generarPDF'])->name('ventas.pdf');
    })->middleware('can:ventas');

    // Otras vistas
    Route::get('/recetas', [RecetasController::class, 'index'])
        ->name('recetas')
        ->middleware('can:recetas');

    Route::get('/obras_sociales', [ObrasSocialesController::class, 'index'])
        ->name('obras_sociales')
        ->middleware('can:obras_sociales');

    Route::get('/proveedores', [ProveedoresController::class, 'index'])
        ->name('proveedores')
        ->middleware('can:proveedores');

    Route::get('/roles', [RolesController::class, 'index'])
        ->name('roles')
        ->middleware('can:roles');

    Route::get('/reportes', [ReportesController::class, 'index'])
        ->name('reportes')
        ->middleware('can:reportes');

    Route::get('/info', [InfoController::class, 'index'])
        ->name('info')
        ->middleware('can:info');
});