@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Gestión de Productos</h1>
@stop

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" onclick="nuevoProducto()">
                <i class="fas fa-plus"></i> Nuevo Producto
            </button>
        </div>
        <div class="card-body">
            <table id="tabla-productos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Stock Inicial</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Caducidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal Producto -->
    <div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-labelledby="modalProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductoLabel">Nuevo Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formProducto">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <!-- Información básica -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="id_categoria">Categoría</label>
                                    <select class="form-control select2" id="id_categoria" name="id_categoria" required>
                                        <option value="">Seleccione una categoría</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Precios -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio_compra">Precio Compra</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" id="precio_compra" name="precio_compra" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="precio_venta">Precio Venta</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock -->
                            <div class="col-md-12">
                                <h5 class="mt-3">Gestión de Stock</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="stock_inicial">Stock Inicial</label>
                                            <input type="number" class="form-control" id="stock_inicial" name="stock_inicial" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="stock_actual">Stock Actual</label>
                                            <input type="number" class="form-control" id="stock_actual" name="stock_actual" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="stock_minimo">Stock Mínimo</label>
                                            <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reemplazar la sección de Coberturas de Obras Sociales -->
                            <div class="col-md-12">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Coberturas de Obras Sociales</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="obra_social_id">Seleccionar Obra Social</label>
                                                    <select class="form-control" id="obra_social_id">
                                                        <option value="">Seleccione una obra social</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="porcentaje_cobertura">Porcentaje de Cobertura</label>
                                                    <div class="input-group">
                                                        <input type="number" 
                                                               class="form-control" 
                                                               id="porcentaje_cobertura"
                                                               min="0" 
                                                               max="100" 
                                                               step="0.01"
                                                               placeholder="Ej: 40">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Tabla de coberturas agregadas -->
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered table-sm">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Obra Social</th>
                                                        <th>Porcentaje de Cobertura</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabla-coberturas">
                                                    <!-- Aquí se mostrarán las coberturas agregadas -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fecha de Caducidad -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="caducidad">Fecha de Caducidad</label>
                                    <input type="date" class="form-control" id="caducidad" name="caducidad">
                                </div>
                            </div>
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

    <!-- Modal Coberturas -->
    <div class="modal fade" id="modalCoberturas" tabindex="-1" role="dialog" aria-labelledby="modalCoberturasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCoberturasLabel">Gestionar Coberturas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formCoberturas">
                        @csrf
                        <input type="hidden" id="producto_id" name="producto_id">
                        
                        <!-- Agregar nueva cobertura -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select class="form-control select2" id="obra_social_id" name="obra_social_id" required>
                                    <option value="">Seleccione una Obra Social</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="descuento" name="descuento" 
                                       placeholder="Descuento %" min="0" max="100" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de coberturas existentes -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Obra Social</th>
                                <th>Descuento</th>
                                <th>Precio Final</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-coberturas">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/productos/index.js') }}"></script>
@stop