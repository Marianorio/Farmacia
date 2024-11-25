<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\VistaAdminController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentasController;
use App\Http\Middleware\CheckRole;

/*-------------------------- INICIO --------------------------*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*-------------------------- RUTAS PROTEGIDAS --------------------------*/
Route::middleware(['auth'])->group(function () {
    // Rutas básicas
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::get('/profile', [UserController::class, 'index'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'update'])->name('user.update');

    // Grupo de rutas protegidas para el Titular
    Route::middleware(['checkrole:Titular'])->group(function () {
        // Vista Admin routes
        Route::get('/vista_admin', [VistaAdminController::class, 'index'])->name('vista_admin');
        Route::post('/vista_admin', [VistaAdminController::class, 'store'])->name('admin_user.store');
        Route::get('/vista_admin/{id}/edit', [VistaAdminController::class, 'edit'])->name('admin_user.edit');
        Route::post('/vista_admin/{id}', [VistaAdminController::class, 'update'])->name('admin_user.update');
        Route::delete('/vista_admin/{id}', [VistaAdminController::class, 'destroy'])->name('admin_user.destroy');

        // Productos routes
        Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
        Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
        Route::get('/productos/{id}/pdf', [ProductoController::class, 'generarPDF'])->name('productos.pdf');

        // Ventas routes
        Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
        Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
        Route::get('/ventas/{id}', [VentasController::class, 'show'])->name('ventas.show');
        Route::delete('/ventas/{id}', [VentasController::class, 'destroy'])->name('ventas.destroy');
        Route::get('/ventas/{id}/pdf', [VentasController::class, 'generarPDF'])->name('ventas.pdf');

        // Rutas de vistas simples
        Route::get('/recetas', function () {
            return view('recetas.recetas');
        })->name('recetas');

        Route::get('/obras_sociales', function () {
            return view('obras_sociales.obras_sociales');
        })->name('obras_sociales');

        Route::get('/proveedores', function () {
            return view('proveedores.proveedores');
        })->name('proveedores');

        Route::get('/roles', function () {
            return view('roles.roles');
        })->name('roles');

        Route::get('/reportes', function () {
            return view('reportes.reportes');
        })->name('reportes');
        
        Route::get('/info', function () {
            return view('info.info');
        })->name('info');
    });
});