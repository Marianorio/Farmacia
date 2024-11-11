{{-- resources/views/productos/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Producto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Precio Compra:</label>
            <input type="number" name="precio_compra" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Precio Venta:</label>
            <input type="number" name="precio_venta" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stock Inicial:</label>
            <input type="number" name="stock_inicial" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stock Actual:</label>
            <input type="number" name="stock_actual" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stock Mínimo:</label>
            <input type="number" name="stock_minimo" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Fecha de Caducidad:</label>
            <input type="date" name="caducidad" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
