@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>Gestión de Ventas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Lista de Ventas</h3>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevaVentaModal">
                        <i class="fas fa-plus"></i> Nueva Venta
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="tablaPrincipal">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ $venta->fecha }}</td>
                        <td>${{ number_format($venta->total, 2) }}</td>
                        <td><span class="badge badge-{{ $venta->estado == 'COMPLETADA' ? 'success' : 'warning' }}">{{ $venta->estado }}</span></td>
                        <td>
                            <button class="btn btn-info btn-sm ver-venta" data-id="{{ $venta->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="{{ route('ventas.pdf', $venta->id) }}" class="btn btn-secondary btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <button class="btn btn-danger btn-sm eliminar-venta" data-id="{{ $venta->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Nueva Venta -->
    <div class="modal fade" id="nuevaVentaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Venta</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNuevaVenta">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control" name="id_cliente" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="productos-container">
                            <div class="producto-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Producto</label>
                                            <select class="form-control producto-select" required>
                                                <option value="">Seleccione un producto</option>
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}">
                                                        {{ $producto->nombre }} - ${{ $producto->precio_venta }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cantidad</label>
                                            <input type="number" class="form-control cantidad-input" min="1" value="1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success mt-4 agregar-producto">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarVenta">Guardar Venta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Venta -->
    <div class="modal fade" id="verVentaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de la Venta</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detallesVenta"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnDescargarPDF">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tablaPrincipal').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                }
            });

            // Agregar producto
            $('.agregar-producto').click(function() {
                const container = $('.productos-container');
                const nuevoProducto = `
                    <div class="producto-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto</label>
                                    <select class="form-control producto-select" required>
                                        <option value="">Seleccione un producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}">
                                                {{ $producto->nombre }} - ${{ $producto->precio_venta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control cantidad-input" min="1" value="1" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger mt-4 eliminar-producto">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.append(nuevoProducto);
            });

            // Eliminar producto
            $(document).on('click', '.eliminar-producto', function() {
                $(this).closest('.producto-item').remove();
            });

            // Guardar venta
            $('#guardarVenta').click(function() {
                // Validar cliente
                const clienteId = $('select[name="id_cliente"]').val();
                if (!clienteId) {
                    Swal.fire('Error', 'Debe seleccionar un cliente', 'error');
                    return;
                }

                // Recolectar productos
                const productos = [];
                let isValid = true;

                $('.producto-item').each(function() {
                    const productoId = $(this).find('.producto-select').val();
                    const cantidad = $(this).find('.cantidad-input').val();
                    
                    if (!productoId || !cantidad) {
                        isValid = false;
                        return false;
                    }

                    productos.push({
                        id: productoId,
                        cantidad: parseInt(cantidad)
                    });
                });

                if (!isValid) {
                    Swal.fire('Error', 'Por favor complete todos los campos de productos', 'error');
                    return;
                }

                if (productos.length === 0) {
                    Swal.fire('Error', 'Debe agregar al menos un producto', 'error');
                    return;
                }

                // Debug
                console.log('Datos a enviar:', {
                    id_cliente: clienteId,
                    productos: productos
                });

                // Mostrar loading
                Swal.fire({
                    title: 'Guardando venta...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Enviar petición
                $.ajax({
                    url: "{{ route('ventas.store') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_cliente: clienteId,
                        productos: productos
                    },
                    success: function(response) {
                        console.log('Respuesta del servidor:', response);
                        if(response.success) {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: 'Venta guardada correctamente',
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message || 'Error al guardar la venta', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error en la petición:', xhr);
                        let errorMessage = 'Error al guardar la venta';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            let ventaIdActual; // Variable para almacenar el ID de la venta actual

            // Ver detalles de venta
            $('.ver-venta').click(function() {
                ventaIdActual = $(this).data('id');
                
                Swal.fire({
                    title: 'Cargando...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: `/ventas/${ventaIdActual}`,
                    method: 'GET',
                    success: function(response) {
                        Swal.close();
                        // Debug para ver qué datos llegan
                        console.log('Respuesta del servidor:', response);
                        
                        if (response.success) {
                            const venta = response.data;
                            let html = `
                                <div class="table-responsive">
                                    <p><strong>Cliente:</strong> ${venta.cliente ? venta.cliente.nombre : 'Cliente no disponible'}</p>
                                    <p><strong>Fecha:</strong> ${venta.fecha || 'Fecha no disponible'}</p>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unit.</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                            
                            if (venta.detalles && venta.detalles.length > 0) {
                                venta.detalles.forEach(detalle => {
                                    html += `
                                        <tr>
                                            <td>${detalle.producto ? detalle.producto.nombre : 'Producto no disponible'}</td>
                                            <td>${detalle.cantidad || 0}</td>
                                            <td>$${detalle.precio_unitario ? parseFloat(detalle.precio_unitario).toFixed(2) : '0.00'}</td>
                                            <td>$${detalle.subtotal ? parseFloat(detalle.subtotal).toFixed(2) : '0.00'}</td>
                                        </tr>`;
                                });
                            } else {
                                html += `
                                    <tr>
                                        <td colspan="4" class="text-center">No hay detalles disponibles</td>
                                    </tr>`;
                            }
                            
                            html += `
                                </tbody>
                            </table>
                            <h5 class="text-right">
                                <strong>Total:</strong> $${venta.total ? parseFloat(venta.total).toFixed(2) : '0.00'}
                            </h5>
                        </div>`;
                            
                            $('#detallesVenta').html(html);
                            $('#verVentaModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error en la petición:', xhr);
                        Swal.fire('Error', 'No se pudieron cargar los detalles de la venta', 'error');
                    }
                });
            });

            // Evento click para el botón de PDF
            $('#btnDescargarPDF').click(function(e) {
                e.preventDefault();
                if (ventaIdActual) {
                    window.open(`/ventas/${ventaIdActual}/pdf`, '_blank');
                } else {
                    alert('Error: No se pudo identificar la venta');
                }
            });

            // Eliminar venta
            $('.eliminar-venta').click(function() {
                if(confirm('¿Está seguro de eliminar esta venta?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/ventas/${id}`,
                        method: 'DELETE',
                        success: function(response) {
                            if(response.success) {
                                location.reload();
                            } else {
                                alert('Error al eliminar la venta');
                            }
                        },
                        error: function(xhr) {
                            alert('Error al eliminar la venta: ' + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@stop