@php
    use Illuminate\Support\Str;
@endphp

@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Gestión de Productos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Lista de Productos</h3>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProducto">
                        <i class="fas fa-plus"></i> Nuevo Producto
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="tabla-productos">
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
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ Str::limit($producto->descripcion, 50) }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>${{ number_format($producto->precio_compra, 2) }}</td>
                        <td>${{ number_format($producto->precio_venta, 2) }}</td>
                        <td>{{ $producto->stock_inicial }}</td>
                        <td>
                            <span class="badge badge-{{ $producto->stock_actual > $producto->stock_minimo ? 'success' : 'danger' }}">
                                {{ $producto->stock_actual }}
                            </span>
                        </td>
                        <td>{{ $producto->stock_minimo }}</td>
                        <td>{{ $producto->caducidad ? date('d/m/Y', strtotime($producto->caducidad)) : 'N/A' }}</td>
                        <td>
                            <button class="btn btn-info btn-sm editar-producto" data-id="{{ $producto->id }}" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm eliminar-producto" data-id="{{ $producto->id }}" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
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
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_proveedor">Proveedor <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="id_proveedor" name="id_proveedor" required>
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                        @endforeach
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
                                                        @foreach($obrasSociales as $obraSocial)
                                                            <option value="{{ $obraSocial->id }}">{{ $obraSocial->nombre }}</option>
                                                        @endforeach
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
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tabla-productos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "columnDefs": [
                    { "width": "5%", "targets": 0 }, // ID
                    { "width": "10%", "targets": 1 }, // Nombre
                    { "width": "15%", "targets": 2 }, // Descripción
                    { "width": "10%", "targets": 3 }, // Categoría
                    { "width": "8%", "targets": [4,5] }, // Precios
                    { "width": "7%", "targets": [6,7,8] }, // Stocks
                    { "width": "10%", "targets": 9 }, // Caducidad
                    { "width": "10%", "targets": -1 }, // Acciones
                ],
                "responsive": true,
                "scrollX": true
            });

            // Eliminar producto
            $(document).on('click', '.eliminar-producto', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/productos/${id}`,
                            method: 'DELETE',
                            success: function(response) {
                                if(response.success) {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });

            // Editar producto
            $(document).on('click', '.editar-producto', function() {
                const id = $(this).data('id');
                $.get(`/productos/${id}`, function(data) {
                    $('#id').val(data.id);
                    $('#nombre').val(data.nombre);
                    $('#descripcion').val(data.descripcion);
                    $('#id_categoria').val(data.id_categoria);
                    $('#precio_compra').val(data.precio_compra);
                    $('#precio_venta').val(data.precio_venta);
                    $('#stock_inicial').val(data.stock_inicial);
                    $('#stock_actual').val(data.stock_actual);
                    $('#stock_minimo').val(data.stock_minimo);
                    $('#caducidad').val(data.caducidad);
                    
                    $('#modalProductoLabel').text('Editar Producto');
                    $('#modalProducto').modal('show');
                });
            });

            // Inicializar Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Manejar la adición de obras sociales
            $('#agregar-cobertura').click(function() {
                const obraSocialId = $('#obra_social_id').val();
                const obraSocialNombre = $('#obra_social_id option:selected').text();
                const porcentajeCobertura = $('#porcentaje_cobertura').val();

                if (!obraSocialId || !porcentajeCobertura) {
                    Swal.fire('Error', 'Por favor complete todos los campos', 'error');
                    return;
                }

                // Verificar si la obra social ya está agregada
                if ($(`#cobertura-${obraSocialId}`).length > 0) {
                    Swal.fire('Error', 'Esta obra social ya está agregada', 'error');
                    return;
                }

                // Agregar fila a la tabla
                $('#tabla-coberturas').append(`
                    <tr id="cobertura-${obraSocialId}">
                        <td>${obraSocialNombre}</td>
                        <td>${porcentajeCobertura}%</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm eliminar-cobertura" 
                                    data-id="${obraSocialId}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <input type="hidden" name="obras_sociales[][id]" value="${obraSocialId}">
                            <input type="hidden" name="obras_sociales[][porcentaje_cobertura]" value="${porcentajeCobertura}">
                        </td>
                    </tr>
                `);

                // Limpiar campos
                $('#obra_social_id').val('').trigger('change');
                $('#porcentaje_cobertura').val('');
            });

            // Eliminar cobertura
            $(document).on('click', '.eliminar-cobertura', function() {
                $(this).closest('tr').remove();
            });

            // Al editar un producto, cargar sus obras sociales
            $(document).on('click', '.editar-producto', function() {
                const id = $(this).data('id');
                $.get(`/productos/${id}`, function(data) {
                    // ... código existente de carga de datos ...

                    // Limpiar tabla de coberturas
                    $('#tabla-coberturas').empty();

                    // Cargar obras sociales existentes
                    data.obras_sociales.forEach(function(obraSocial) {
                        $('#tabla-coberturas').append(`
                            <tr id="cobertura-${obraSocial.id}">
                                <td>${obraSocial.nombre}</td>
                                <td>${obraSocial.pivot.porcentaje_cobertura}%</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm eliminar-cobertura" 
                                            data-id="${obraSocial.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <input type="hidden" name="obras_sociales[][id]" value="${obraSocial.id}">
                                    <input type="hidden" name="obras_sociales[][porcentaje_cobertura]" 
                                           value="${obraSocial.pivot.porcentaje_cobertura}">
                                </td>
                            </tr>
                        `);
                    });
                });
            });

            // Manejar el envío del formulario
            $('#formProducto').on('submit', function(e) {
                e.preventDefault();
                
                let formData = new FormData(this);
                
                // Recolectar datos de obras sociales
                let obrasSociales = [];
                $('#tabla-coberturas tr').each(function() {
                    obrasSociales.push({
                        id: $(this).find('input[name="obras_sociales[][id]"]').val(),
                        porcentaje_cobertura: $(this).find('input[name="obras_sociales[][porcentaje_cobertura]"]').val()
                    });
                });
                
                // Eliminar el campo anterior si existe
                formData.delete('obras_sociales');
                
                // Agregar obras sociales como un array JSON
                formData.append('obras_sociales', JSON.stringify(obrasSociales));

                // Debug: Mostrar datos que se están enviando
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                $.ajax({
                    url: '/productos',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#modalProducto').modal('hide');
                            Swal.fire('¡Éxito!', 'Producto guardado correctamente', 'success')
                            .then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (let field in errors) {
                            errorMessage += `${errors[field].join('\n')}\n`;
                        }
                        Swal.fire('Error', errorMessage, 'error');
                        console.log('Errores de validación:', errors); // Para debug
                    }
                });
            });
        });
    </script>
@stop