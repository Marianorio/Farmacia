@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Gestión de Proveedores</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Proveedores</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-nuevo-proveedor">
                    <i class="fas fa-plus"></i> Nuevo Proveedor
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="proveedores" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Fecha Creación</th>
                        <th>Información Adicional</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->id }}</td>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->contacto }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>{{ $proveedor->email }}</td>
                            <td>{{ $proveedor->fecha_creacion }}</td>
                            <td>{{ $proveedor->informacion_adicional }}</td>
                            <td>
                                <button class="btn btn-sm btn-info ver-productos" data-id="{{ $proveedor->id }}">
                                    <i class="fas fa-box"></i> Ver Productos
                                </button>
                                <button class="btn btn-sm btn-warning edit-proveedor" data-id="{{ $proveedor->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-proveedor" data-id="{{ $proveedor->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-labelledby="modalProveedorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProveedorLabel">Nuevo Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="proveedorForm" method="POST">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="contacto">Contacto</label>
                            <input type="text" class="form-control" id="contacto" name="contacto" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="informacion_adicional">Información Adicional</label>
                            <textarea class="form-control" id="informacion_adicional" name="informacion_adicional"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
@stop

<div class="modal fade" id="modalProductosProveedor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Productos del Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="productos-por-categoria"></div>
                
            </div>
        </div>
    </div>
</div>

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('proveedores.js') }}"></script>
@stop

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop