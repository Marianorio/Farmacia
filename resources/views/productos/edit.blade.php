{{-- resources/views/productos/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
        </div>
        <div class="form-group">
            <label>Precio Compra:</label>
            <input type="number" name="precio_compra" value="{{ $producto->precio_compra }}" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Precio Venta:</label>
            <input type="number" name="precio_venta" value="{{ $producto->precio_venta }}" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stock Inicial:</label>
            <input type="number" name="stock_inicial" value="{{ $producto->stock_inicial }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stock Actual:</label>
            <input type="number" name="stock_actual" value="{{ $producto->stock_actual }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stock Mínimo:</label>
            <input type="number" name="stock_minimo" value="{{ $producto->stock_minimo }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Fecha de Caducidad:</label>
            <input type="date" name="caducidad" value="{{ $producto->caducidad }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
