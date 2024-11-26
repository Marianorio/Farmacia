@extends('adminlte::page')

@section('title', 'Guía del Sistema')

@section('content_header')
    <h1><i class="fas fa-book"></i> Guía del Sistema</h1>
@stop

@section('content')
    <div class="row">
        <!-- Sección de Navegación -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Índice</h3>
                </div>
                <div class="card-body">
                    <div class="nav flex-column nav-pills" role="tablist">
                        <a class="nav-link active" data-toggle="pill" href="#inicio">Inicio</a>
                        <a class="nav-link" data-toggle="pill" href="#usuarios">Gestión de Usuarios</a>
                        <a class="nav-link" data-toggle="pill" href="#productos">Gestión de Productos</a>
                        <a class="nav-link" data-toggle="pill" href="#proveedores">Gestión de Proveedores</a>
                        <a class="nav-link" data-toggle="pill" href="#obras-sociales">Gestión de Obras Sociales</a>
                        <!-- Agrega más secciones según necesites -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Sección Inicio -->
                <div class="tab-pane fade show active" id="inicio">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Bienvenido al Sistema</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Esta guía te ayudará a conocer las funcionalidades principales del sistema.
                            </div>
                            <h5>Primeros Pasos</h5>
                            <ol>
                                <li>Familiarízate con el menú lateral</li>
                                <li>Revisa tus permisos de usuario</li>
                                <li>Actualiza tu perfil</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Sección Usuarios -->
                <div class="tab-pane fade" id="usuarios">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h3 class="card-title">Gestión de Usuarios</h3>
                        </div>
                        <div class="card-body">
                            <!-- Contenido sobre gestión de usuarios -->
                        </div>
                    </div>
                </div>

                <!-- Sección Productos -->
                <div class="tab-pane fade" id="productos">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h3 class="card-title">Gestión de Productos</h3>
                        </div>
                        <div class="card-body">
                            <!-- Introducción -->
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle"></i> 
                                Este módulo te permite gestionar el catálogo completo de productos, incluyendo precios, stock y coberturas de obras sociales.
                            </div>

                            <!-- Listado de Productos -->
                            <div class="mb-4">
                                <h4><i class="fas fa-list"></i> Listado de Productos</h4>
                                <div class="pl-4">
                                    <p>La tabla principal muestra:</p>
                                    <ul>
                                        <li>ID y Nombre del producto</li>
                                        <li>Descripción y Categoría</li>
                                        <li>Precios (Compra y Venta)</li>
                                        <li>Control de Stock (Inicial, Actual y Mínimo)</li>
                                        <li>Fecha de Caducidad</li>
                                    </ul>
                                    <div class="alert alert-success">
                                        <i class="fas fa-lightbulb"></i> 
                                        <strong>Tip:</strong> Utiliza la barra de búsqueda para filtrar productos específicos.
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones Principales -->
                            <div class="mb-4">
                                <h4><i class="fas fa-tools"></i> Acciones Disponibles</h4>
                                <div class="pl-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card bg-success text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-eye"></i> Ver Detalles</h5>
                                                    <p>Botón verde que muestra información completa del producto, incluyendo coberturas de obras sociales.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-edit"></i> Editar</h5>
                                                    <p>Botón azul para modificar datos del producto y sus coberturas.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-danger text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-trash"></i> Eliminar</h5>
                                                    <p>Botón rojo para eliminar productos (requiere confirmación).</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gestión de Coberturas -->
                            <div class="mb-4">
                                <h4><i class="fas fa-hand-holding-medical"></i> Coberturas de Obras Sociales</h4>
                                <div class="pl-4">
                                    <p>Para cada producto puedes:</p>
                                    <ol>
                                        <li>Seleccionar una obra social del listado</li>
                                        <li>Establecer el porcentaje de cobertura (0-100%)</li>
                                        <li>Ver el precio final con descuento aplicado</li>
                                        <li>Eliminar coberturas existentes</li>
                                    </ol>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Importante:</strong> Los porcentajes de cobertura afectan directamente al precio final del producto.
                                    </div>
                                </div>
                            </div>

                            <!-- Control de Stock -->
                            <div class="mb-4">
                                <h4><i class="fas fa-boxes"></i> Control de Inventario</h4>
                                <div class="pl-4">
                                    <p>El sistema maneja tres niveles de stock:</p>
                                    <ul>
                                        <li><strong>Stock Inicial:</strong> Cantidad con la que se registra el producto</li>
                                        <li><strong>Stock Actual:</strong> Cantidad disponible en tiempo real</li>
                                        <li><strong>Stock Mínimo:</strong> Nivel de alerta para reabastecimiento</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección Proveedores -->
                <div class="tab-pane fade" id="proveedores">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Gestión de Proveedores</h3>
                        </div>
                        <div class="card-body">
                            <!-- Introducción -->
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle"></i> 
                                Este módulo permite administrar los proveedores del sistema y ver los productos asociados a cada uno.
                            </div>

                            <!-- Listado Principal -->
                            <div class="mb-4">
                                <h4><i class="fas fa-list"></i> Lista de Proveedores</h4>
                                <div class="pl-4">
                                    <p>La tabla muestra la siguiente información:</p>
                                    <ul>
                                        <li><strong>ID:</strong> Identificador único del proveedor</li>
                                        <li><strong>Nombre:</strong> Nombre comercial del proveedor</li>
                                        <li><strong>Contacto:</strong> Persona de contacto</li>
                                        <li><strong>Dirección:</strong> Ubicación física</li>
                                        <li><strong>Teléfono y Email:</strong> Datos de contacto</li>
                                        <li><strong>Fecha Creación:</strong> Cuando se registró el proveedor</li>
                                        <li><strong>Información Adicional:</strong> Notas o datos extra</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Crear Nuevo Proveedor -->
                            <div class="mb-4">
                                <h4><i class="fas fa-plus-circle"></i> Agregar Nuevo Proveedor</h4>
                                <div class="pl-4">
                                    <ol>
                                        <li>Haz clic en el botón <span class="badge badge-primary"><i class="fas fa-plus"></i> Nuevo Proveedor</span></li>
                                        <li>Completa el formulario con:
                                            <ul>
                                                <li>Nombre del proveedor</li>
                                                <li>Información de contacto</li>
                                                <li>Dirección completa</li>
                                                <li>Teléfono y email</li>
                                                <li>Información adicional (opcional)</li>
                                            </ul>
                                        </li>
                                        <li>Presiona "Guardar" para registrar el proveedor</li>
                                    </ol>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Importante:</strong> El email debe ser único para cada proveedor.
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones Disponibles -->
                            <div class="mb-4">
                                <h4><i class="fas fa-tools"></i> Acciones por Proveedor</h4>
                                <div class="pl-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card bg-info text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-box"></i> Ver Productos</h5>
                                                    <p>Muestra todos los productos asociados al proveedor, incluyendo categoría, precio y stock.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-edit"></i> Editar</h5>
                                                    <p>Permite modificar la información del proveedor.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-danger text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-trash"></i> Eliminar</h5>
                                                    <p>Elimina el proveedor del sistema (requiere confirmación).</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Productos por Proveedor -->
                            <div class="mb-4">
                                <h4><i class="fas fa-boxes"></i> Visualización de Productos</h4>
                                <div class="pl-4">
                                    <p>Al hacer clic en "Ver Productos", se mostrará:</p>
                                    <ul>
                                        <li>Nombre del producto</li>
                                        <li>Categoría</li>
                                        <li>Precio de compra</li>
                                        <li>Stock actual</li>
                                    </ul>
                                    <div class="alert alert-success">
                                        <i class="fas fa-lightbulb"></i>
                                        <strong>Tip:</strong> Esta vista te ayuda a identificar rápidamente qué productos suministra cada proveedor.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección Obras Sociales -->
                <div class="tab-pane fade" id="obras-sociales">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Gestión de Obras Sociales</h3>
                        </div>
                        <div class="card-body">
                            <!-- Introducción -->
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle"></i> 
                                Este módulo permite administrar las obras sociales y sus coberturas para los productos del sistema.
                            </div>

                            <!-- Listado Principal -->
                            <div class="mb-4">
                                <h4><i class="fas fa-list"></i> Lista de Obras Sociales</h4>
                                <div class="pl-4">
                                    <p>La tabla muestra la siguiente información:</p>
                                    <ul>
                                        <li><strong>ID:</strong> Identificador único</li>
                                        <li><strong>Nombre:</strong> Nombre de la obra social</li>
                                        <li><strong>CUIT:</strong> Número de identificación fiscal</li>
                                        <li><strong>Fecha Convenio:</strong> Inicio del convenio</li>
                                        <li><strong>Fecha Vencimiento:</strong> Finalización del convenio</li>
                                    </ul>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Importante:</strong> Mantén actualizadas las fechas de convenio para evitar inconvenientes con las coberturas.
                                    </div>
                                </div>
                            </div>

                            <!-- Nueva Obra Social -->
                            <div class="mb-4">
                                <h4><i class="fas fa-plus-circle"></i> Registrar Nueva Obra Social</h4>
                                <div class="pl-4">
                                    <ol>
                                        <li>Haz clic en <span class="badge badge-primary"><i class="fas fa-plus"></i> Nueva Obra Social</span></li>
                                        <li>Completa los campos requeridos:
                                            <ul>
                                                <li>Nombre de la obra social</li>
                                                <li>CUIT (debe ser único)</li>
                                                <li>Fecha de inicio del convenio</li>
                                                <li>Fecha de vencimiento del convenio</li>
                                            </ul>
                                        </li>
                                        <li>Presiona "Guardar" para registrar</li>
                                    </ol>
                                    <div class="alert alert-info">
                                        <i class="fas fa-lightbulb"></i>
                                        <strong>Tip:</strong> La fecha de vencimiento debe ser posterior a la fecha de convenio.
                                    </div>
                                </div>
                            </div>

                            <!-- Gestión de Productos y Coberturas -->
                            <div class="mb-4">
                                <h4><i class="fas fa-percentage"></i> Productos y Coberturas</h4>
                                <div class="pl-4">
                                    <p>Para cada obra social puedes:</p>
                                    <ul>
                                        <li>Ver los productos cubiertos</li>
                                        <li>Revisar los porcentajes de cobertura</li>
                                        <li>Verificar las descripciones de productos</li>
                                    </ul>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Nota:</strong> Los porcentajes de cobertura se pueden gestionar desde el módulo de productos.
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones Disponibles -->
                            <div class="mb-4">
                                <h4><i class="fas fa-tools"></i> Acciones por Obra Social</h4>
                                <div class="pl-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card bg-success text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-eye"></i> Ver Productos</h5>
                                                    <p>Muestra todos los productos con cobertura y sus porcentajes.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-edit"></i> Editar</h5>
                                                    <p>Modifica la información básica de la obra social.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-danger text-white">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-trash"></i> Eliminar</h5>
                                                    <p>Elimina la obra social y sus relaciones con productos.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Validaciones y Restricciones -->
                            <div class="mb-4">
                                <h4><i class="fas fa-shield-alt"></i> Validaciones del Sistema</h4>
                                <div class="pl-4">
                                    <ul>
                                        <li>El CUIT debe ser único para cada obra social</li>
                                        <li>Las fechas de convenio deben ser válidas y coherentes</li>
                                        <li>No se pueden duplicar coberturas para un mismo producto</li>
                                        <li>Se mantiene un registro de todas las modificaciones</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .nav-pills .nav-link {
            margin-bottom: 5px;
        }
        .card-body ol li {
            margin-bottom: 10px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Activar tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Mantener la pestaña activa después de recargar
            var hash = window.location.hash;
            if (hash) {
                $('.nav-pills a[href="' + hash + '"]').tab('show');
            }

            // Actualizar URL cuando cambie la pestaña
            $('.nav-pills a').on('click', function (e) {
                $(this).tab('show');
                window.location.hash = this.hash;
            });
        });
    </script>
@stop