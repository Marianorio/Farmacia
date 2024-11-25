<?php

use Illuminate\Support\Facades\Route;

/*-------------------------- INICIO --------------------------*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*-------------------------- VISTAS --------------------------*/

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');

    Route::middleware(['permission:vista_admin'])->group(function () {
        Route::get('/vista_admin', [App\Http\Controllers\VistaAdminController::class, 'index'])->name('vista_admin');
        Route::post('/vista_admin', [App\Http\Controllers\VistaAdminController::class, 'store'])->name('admin_user.store');
        Route::get('/vista_admin/{id}/edit', [App\Http\Controllers\VistaAdminController::class, 'edit'])->name('admin_user.edit');
        Route::post('/vista_admin/{id}', [App\Http\Controllers\VistaAdminController::class, 'update'])->name('admin_user.update');
        Route::delete('/vista_admin/{id}', [App\Http\Controllers\VistaAdminController::class, 'destroy'])->name('admin_user.destroy');
    });

    Route::middleware(['permission:productos'])->group(function () {
        Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos');
        Route::post('/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('productos.show');
        Route::delete('/productos/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');
        Route::get('/productos/{id}/pdf', [App\Http\Controllers\ProductoController::class, 'generarPDF'])->name('productos.pdf');
    });

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

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [UserController::class, 'index'])->name('user.profile');
        Route::post('/profile', [UserController::class, 'update'])->name('user.update');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
        Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
        Route::get('/ventas/{id}', [VentasController::class, 'show'])->name('ventas.show');
        Route::delete('/ventas/{id}', [VentasController::class, 'destroy'])->name('ventas.destroy');
        Route::get('/ventas/{id}/pdf', [VentasController::class, 'generarPDF'])->name('ventas.pdf');
    });
});

