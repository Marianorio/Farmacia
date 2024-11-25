@extends('adminlte::page')

@section('title', 'Obras Sociales')

@section('content_header')
    <h1>Gestión de Obras Sociales</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h3>Lista de Obras Sociales</h3>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevaObraSocial">
                    <i class="fas fa-plus"></i> Nueva Obra Social
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="tabla-obras-sociales" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="25%">Nombre</th>
                    <th width="20%">CUIT</th>
                    <th width="15%">Fecha Convenio</th>
                    <th width="15%">Fecha Vencimiento</th>
                    <th width="20%">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargarán vía DataTables/Ajax -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Nueva Obra Social -->
<div class="modal fade" id="modalNuevaObraSocial" tabindex="-1" role="dialog" aria-labelledby="modalNuevaObraSocialLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaObraSocialLabel">Nueva Obra Social</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNuevaObraSocial">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="cuit">CUIT</label>
                        <input type="text" class="form-control" id="cuit" name="cuit" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_convenio">Fecha Convenio</label>
                        <input type="date" class="form-control" id="fecha_convenio" name="fecha_convenio" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_vencimiento_convenio">Fecha Vencimiento</label>
                        <input type="date" class="form-control" id="fecha_vencimiento_convenio" name="fecha_vencimiento_convenio" required>
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

<!-- Modal Editar Obra Social -->
<div class="modal fade" id="modalEditarObraSocial" tabindex="-1" role="dialog" aria-labelledby="modalEditarObraSocialLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarObraSocialLabel">Editar Obra Social</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarObraSocial">
                @csrf
                <input type="hidden" id="editar_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editar_nombre">Nombre</label>
                        <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editar_cuit">CUIT</label>
                        <input type="text" class="form-control" id="editar_cuit" name="cuit" required>
                    </div>
                    <div class="form-group">
                        <label for="editar_fecha_convenio">Fecha Convenio</label>
                        <input type="date" class="form-control" id="editar_fecha_convenio" name="fecha_convenio" required>
                    </div>
                    <div class="form-group">
                        <label for="editar_fecha_vencimiento_convenio">Fecha Vencimiento</label>
                        <input type="date" class="form-control" id="editar_fecha_vencimiento_convenio" name="fecha_vencimiento_convenio" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Productos de Obra Social -->
<div class="modal fade" id="modalProductosObraSocial" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Productos Cubiertos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Porcentaje Cobertura</th>
                        </tr>
                    </thead>
                    <tbody id="productos-body">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Inicializar DataTable con configuración corregida
            const tabla = $('#tabla-obras-sociales').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/obras_sociales/data",
                    "type": "GET",
                    "error": function(xhr, error, thrown) {
                        console.log('Error en DataTables:', error);
                        Swal.fire('Error', 'Hubo un error al cargar los datos', 'error');
                    }
                },
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'cuit', name: 'cuit'},
                    {data: 'fecha_convenio', name: 'fecha_convenio'},
                    {data: 'fecha_vencimiento_convenio', name: 'fecha_vencimiento_convenio'},
                    {
                        data: 'id',
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <button class="btn btn-info btn-sm editar-obra-social" data-id="${data}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm eliminar-obra-social" data-id="${data}" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-success btn-sm ver-productos" data-id="${data}" title="Ver Productos">
                                    <i class="fas fa-pills"></i>
                                </button>
                            `;
                        }
                    }
                ],
                "responsive": true,
                "autoWidth": false,
                "order": [[0, 'desc']]
            });

            // Crear nueva obra social
            $('#formNuevaObraSocial').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/obras_sociales',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modalNuevaObraSocial').modal('hide');
                        tabla.ajax.reload();
                        Swal.fire('¡Éxito!', 'Obra social creada correctamente', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Hubo un error al crear la obra social', 'error');
                    }
                });
            });

            // Eliminar obra social
            $(document).on('click', '.eliminar-obra-social', function() {
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
                            url: `/obras_sociales/${id}`,
                            method: 'DELETE',
                            success: function(response) {
                                tabla.ajax.reload();
                                Swal.fire('¡Eliminado!', 'La obra social ha sido eliminada', 'success');
                            }
                        });
                    }
                });
            });

            // Cargar datos para editar
            $(document).on('click', '.editar-obra-social', function() {
                const id = $(this).data('id');
                $.get(`/obras_sociales/${id}`, function(data) {
                    $('#editar_id').val(data.id);
                    $('#editar_nombre').val(data.nombre);
                    $('#editar_cuit').val(data.cuit);
                    $('#editar_fecha_convenio').val(data.fecha_convenio);
                    $('#editar_fecha_vencimiento_convenio').val(data.fecha_vencimiento_convenio);
                    $('#modalEditarObraSocial').modal('show');
                });
            });

            // Ver productos
            $(document).on('click', '.ver-productos', function() {
                const id = $(this).data('id');
                $.get(`/obras_sociales/${id}/productos`, function(data) {
                    $('#productos-body').empty();
                    data.forEach(producto => {
                        $('#productos-body').append(`
                            <tr>
                                <td>${producto.nombre}</td>
                                <td>${producto.descripcion}</td>
                                <td>${producto.pivot.porcentaje_cobertura}%</td>
                            </tr>
                        `);
                    });
                    $('#modalProductosObraSocial').modal('show');
                });
            });

            // Actualizar obra social
            $('#formEditarObraSocial').on('submit', function(e) {
                e.preventDefault();
                const id = $('#editar_id').val();
                $.ajax({
                    url: `/obras_sociales/${id}`,
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modalEditarObraSocial').modal('hide');
                        tabla.ajax.reload();
                        Swal.fire('¡Éxito!', 'Obra social actualizada correctamente', 'success');
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (let field in errors) {
                            errorMessage += `${errors[field].join('\n')}\n`;
                        }
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            // Limpiar formularios al cerrar modales
            $('#modalNuevaObraSocial, #modalEditarObraSocial').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
            });

            // Validación de fechas
            $('#fecha_vencimiento_convenio, #editar_fecha_vencimiento_convenio').on('change', function() {
                let fechaConvenio = $(this).closest('form').find('[name="fecha_convenio"]').val();
                let fechaVencimiento = $(this).val();
                
                if (fechaVencimiento <= fechaConvenio) {
                    Swal.fire('Error', 'La fecha de vencimiento debe ser posterior a la fecha del convenio', 'error');
                    $(this).val('');
                }
            });
        });
    </script>
@stop