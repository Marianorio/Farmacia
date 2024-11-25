@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
    {{-- Botones de menú --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <a href="{{ route('productos') }}" class="btn btn-lg btn-primary btn-block">
                <i class="fas fa-box"></i> Productos
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('ventas.index') }}" class="btn btn-lg btn-success btn-block">
                <i class="fas fa-shopping-cart"></i> Ventas
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('proveedores') }}" class="btn btn-lg btn-warning btn-block">
                <i class="fas fa-truck"></i> Proveedores
            </a>
        </div>
    </div>

    {{-- Widgets informativos --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Productos con Stock Mínimo</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Mínimo</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Aquí deberás iterar tus productos con stock mínimo --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Productos por Vencer</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Días Restantes</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Aquí deberás iterar tus productos próximos a vencer --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico de ventas --}}
    <div class="row mt-4">
        <div class="col-md-12"></div>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Gráfico de Ventas</h3>
                </div>
                <div class="card-body">
                    <canvas id="ventasChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de ventas
        const ctx = document.getElementById('ventasChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                datasets: [{
                    label: 'Ventas por Mes',
                    data: [12, 19, 3, 5, 2, 3], // Aquí deberás poner tus datos reales
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop