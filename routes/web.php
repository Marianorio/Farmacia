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

Route::get('/productos', function () {
    return view('productos.productos');
})->name('productos');

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
