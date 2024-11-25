<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth; 

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

Route::middleware(['auth', 'role:Titular'])->group(function () {
    Route::get('/vista_admin', [VistaAdminController::class, 'index'])->name('vista_admin');
    Route::post('/vista_admin', [VistaAdminController::class, 'store'])->name('admin_user.store');
    Route::get('/vista_admin/{id}/edit', [VistaAdminController::class, 'edit'])->name('admin_user.edit');
    Route::post('/vista_admin/{id}', [VistaAdminController::class, 'update'])->name('admin_user.update');
    Route::delete('/vista_admin/{id}', [VistaAdminController::class, 'destroy'])->name('admin_user.destroy');
    Route::get('/roles', function () {
        return view('roles.roles');
    })->name('roles');
});

Route::middleware(['auth', 'role:Titular,Adjunto'])->group(function () {
    Route::get('/reportes', function () {
        return view('reportes.reportes');
    })->name('reportes');
    Route::get('/recetas', function () {
        return view('recetas.recetas');
    })->name('recetas');
    Route::get('/obras_sociales', function () {
        return view('obras_sociales.obras_sociales');
    })->name('obras_sociales');
});

Route::middleware(['auth', 'role:Titular,Adjunto,Tecnico'])->group(function () {
    Route::get('/proveedores', function () {
        return view('proveedores.proveedores');
    })->name('proveedores');
    Route::resource('productos', ProductoController::class);
});

Route::middleware(['auth', 'role:Auxiliar'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
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

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Rutas solo para Titular
    Route::middleware(['can:ver-admin'])->group(function () {
        Route::get('/vista_admin', [VistaAdminController::class, 'index'])->name('vista_admin');
        Route::get('/roles', [RolesController::class, 'index'])->name('roles');
    });

    // Rutas para Titular y Adjunto
    Route::middleware(['can:ver-reportes'])->group(function () {
        Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes');
        Route::get('/recetas', [RecetasController::class, 'index'])->name('recetas');
        Route::get('/obras_sociales', [ObrasSocialesController::class, 'index'])->name('obras_sociales');
    });

    // Rutas para Titular, Adjunto y Técnico
    Route::middleware(['can:ver-proveedores'])->group(function () {
        Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores');
    });

    // Rutas de productos con diferentes permisos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::middleware(['can:gestionar-productos'])->group(function () {
        Route::resource('productos', ProductoController::class)->except(['index']);
    });
});