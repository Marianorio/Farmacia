$(document).ready(function() {
    $('#tabla-obras-sociales').DataTable({
        ajax: {
            url: '/obras-sociales/data',
            type: 'GET',
            error: function(xhr, error, thrown) {
                console.error('Error:', error);
            }
        },
        columns: [
            {data: 'id'},
            {data: 'nombre'},
            {data: 'cuit'},
            {data: 'fecha_convenio'},
            {data: 'fecha_vencimiento_convenio'},
            {
                data: 'id',
                render: function(data) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editarObraSocial(${data})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarObraSocial(${data})">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-success btn-sm" onclick="verProductos(${data})">
                                <i class="fas fa-pills"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
});
function guardarObraSocial() {
    let formData = new FormData(document.getElementById('formNuevaObraSocial'));
    
    $.ajax({
        url: "{{ route('obras-sociales.store') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('#modalNuevaObraSocial').modal('hide');
            $('#formNuevaObraSocial').trigger('reset');
            $('#tabla-obras-sociales').DataTable().ajax.reload();
            Swal.fire('¡Éxito!', 'Obra Social guardada correctamente', 'success');
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseJSON);
            let mensaje = xhr.responseJSON?.message || 'No se pudo guardar la Obra Social';
            Swal.fire('Error', mensaje, 'error');
        }
    });
}

function editarObraSocial(id) {
    $.ajax({
        url: `/obras-sociales/${id}`,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#editar_id').val(response.data.id);
                $('#editar_nombre').val(response.data.nombre);
                $('#editar_cuit').val(response.data.cuit);
                $('#editar_fecha_convenio').val(response.data.fecha_convenio);
                $('#editar_fecha_vencimiento_convenio').val(response.data.fecha_vencimiento_convenio);
                $('#modalEditarObraSocial').modal('show');
            }
        },
        error: function(xhr) {
            Swal.fire('Error', 'No se pudo cargar la Obra Social', 'error');
        }
    });
}

$('#formEditarObraSocial').submit(function(e) {
    e.preventDefault();
    let id = $('#editar_id').val();
    let formData = new FormData(this);
    formData.append('_method', 'PUT'); // Para método PUT
    
    $.ajax({
        url: `/obras-sociales/${id}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('#modalEditarObraSocial').modal('hide');
            $('#tabla-obras-sociales').DataTable().ajax.reload();
            Swal.fire('¡Éxito!', 'Obra Social actualizada correctamente', 'success');
        },
        error: function(xhr) {
            let mensaje = xhr.responseJSON?.message || 'No se pudo actualizar la Obra Social';
            Swal.fire('Error', mensaje, 'error');
        }
    });
});

function eliminarObraSocial(id) {
    console.log('Intentando eliminar ID:', id);

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            console.log('Confirmación aceptada, enviando petición DELETE');
            
            $.ajax({
                url: '/obras-sociales/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    $('#tabla-obras-sociales').DataTable().ajax.reload();
                    Swal.fire(
                        '¡Eliminado!',
                        'La Obra Social ha sido eliminada.',
                        'success'
                    );
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    Swal.fire(
                        'Error',
                        'No se pudo eliminar la Obra Social',
                        'error'
                    );
                }
            });
        }
    });
}

$('#formNuevaObraSocial').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    
    $.ajax({
        url: "/obras-sociales",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Limpiar el formulario
                $('#formNuevaObraSocial')[0].reset();
                
                // Cerrar el modal y limpiar el backdrop
                $('#modalNuevaObraSocial').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('padding-right', '');
                
                // Recargar la tabla
                $('#tabla-obras-sociales').DataTable().ajax.reload();
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Obra Social guardada correctamente'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un error al guardar la Obra Social'
                });
            }
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseJSON);
            let mensaje = '';
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                mensaje = Object.values(xhr.responseJSON.errors).flat().join('\n');
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                mensaje = xhr.responseJSON.message;
            } else {
                mensaje = 'No se pudo guardar la Obra Social';
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: mensaje
            });
        }
    });
});

// Agregar función de limpieza cuando se cierra el modal manualmente
$('#modalNuevaObraSocial').on('hidden.bs.modal', function () {
    // Limpiar el formulario
    $('#formNuevaObraSocial')[0].reset();
    
    // Limpiar cualquier backdrop residual
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
});

// Función para asegurar que el modal se cierre correctamente
function limpiarModal() {
    $('#modalNuevaObraSocial').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
    $('#formNuevaObraSocial')[0].reset();
}

// Validación del CUIT en tiempo real
$('#cuit').on('blur', function() {
    let cuit = $(this).val();
    
    $.ajax({
        url: "/obras-sociales/verificar-cuit",
        type: 'POST',
        data: {
            cuit: cuit,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (!response.disponible) {
                Swal.fire({
                    icon: 'warning',
                    title: 'CUIT duplicado',
                    text: 'Este CUIT ya está registrado'
                });
                $('#cuit').val('');
            }
        }
    });
});

// Agregar al final del archivo
$(document).keydown(function(e) {
    // Si se presiona ESC
    if (e.keyCode === 27) {
        limpiarModal();
    }
});

// Agregar un botón de cierre de emergencia (opcional)
$('body').append('<button id="emergencyClose" style="position: fixed; bottom: 10px; right: 10px; display: none; z-index: 9999;" class="btn btn-danger">Cerrar Modal</button>');

$('#emergencyClose').click(function() {
    limpiarModal();
});

// Mostrar el botón de emergencia si el modal está abierto por más de 5 segundos
$('#modalNuevaObraSocial').on('shown.bs.modal', function() {
    setTimeout(function() {
        if ($('#modalNuevaObraSocial').is(':visible')) {
            $('#emergencyClose').show();
        }
    }, 5000);
});

$('#modalNuevaObraSocial').on('hidden.bs.modal', function() {
    $('#emergencyClose').hide();
});

// Función para ver productos
function verProductos(id) {
    $('#productos-body').html('<tr><td colspan="3">Cargando...</td></tr>');
    $('#modalProductosObraSocial').modal('show');

    $.ajax({
        url: '/obras-sociales/' + id + '/productos',
        method: 'GET',
        success: function(response) {
            let html = '';
            
            if (response.data.length === 0) {
                html = '<tr><td colspan="3">No hay productos asociados</td></tr>';
            } else {
                response.data.forEach(function(producto) {
                    html += `
                        <tr>
                            <td>${producto.nombre}</td>
                            <td>${producto.descripcion}</td>
                            <td>${producto.descuento}%</td>
                        </tr>
                    `;
                });
            }
            
            $('#productos-body').html(html);
        },
        error: function() {
            $('#productos-body').html('<tr><td colspan="3">Error al cargar los productos</td></tr>');
        }
    });
}




