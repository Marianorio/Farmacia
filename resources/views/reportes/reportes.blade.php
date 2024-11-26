@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Gestión de Reportes</h1>
@stop

@section('content')
<div class="row">
    <!-- Sección de Obras Sociales -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Reportes de Obras Sociales</h3>
            </div>
            <div class="card-body">
                <form id="obraSocialReporteForm" class="reporte-form">
                    @csrf
                    <input type="hidden" name="tipo" value="obra_social">
                    <div class="form-group">
                        <label for="obra_social_id">Obra Social</label>
                        <select class="form-control" id="obra_social_id" name="obra_social_id">
                            <option value="">Todas las Obras Sociales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Período</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="fecha_inicio" required>
                            <div class="input-group-append input-group-prepend">
                                <span class="input-group-text">hasta</span>
                            </div>
                            <input type="date" class="form-control" name="fecha_fin" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-file-pdf"></i> Generar Reporte
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sección de Ventas -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">Reportes de Ventas</h3>
            </div>
            <div class="card-body">
                <form id="ventasReporteForm" class="reporte-form">
                    @csrf
                    <input type="hidden" name="tipo" value="venta">
                    <div class="form-group">
                        <label>Período</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="fecha_inicio" required>
                            <div class="input-group-append input-group-prepend">
                                <span class="input-group-text">hasta</span>
                            </div>
                            <input type="date" class="form-control" name="fecha_fin" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Reporte</label>
                        <select class="form-control" name="subtipo">
                            <option value="diario">Ventas Diarias</option>
                            <option value="mensual">Ventas Mensuales</option>
                            <option value="productos">Por Productos</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-file-pdf"></i> Generar Reporte
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sección de Proveedores -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">Reportes de Proveedores</h3>
            </div>
            <div class="card-body">
                <form id="proveedoresReporteForm" class="reporte-form">
                    @csrf
                    <input type="hidden" name="tipo" value="proveedor">
                    <div class="form-group">
                        <label for="proveedor_id">Proveedor</label>
                        <select class="form-control" id="proveedor_id" name="proveedor_id">
                            <option value="">Todos los Proveedores</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Período</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="fecha_inicio" required>
                            <div class="input-group-append input-group-prepend">
                                <span class="input-group-text">hasta</span>
                            </div>
                            <input type="date" class="form-control" name="fecha_fin" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">
                        <i class="fas fa-file-pdf"></i> Generar Reporte
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Reportes Generados -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Historial de Reportes</h3>
    </div>
    <div class="card-body">
        <table id="reportesTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Período</th>
                    <th>Generado por</th>
                    <th>Fecha Generación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/reportes.js') }}"></script>
@stop