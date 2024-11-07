<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

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
/*
Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'productos'])->name('productos');
*/
