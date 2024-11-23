@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Vista de Productos</h1>
@stop

@section('content')
<div class="container">
    <h1>Lista de Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Agregar Producto</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Stock Actual</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->descripcion }}</td>
                <td>${{ $producto->precio_compra }}</td>
                <td>${{ $producto->precio_venta }}</td>
                <td>{{ $producto->stock_actual }}</td>
                <td>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop