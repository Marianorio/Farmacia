$(document).ready(function() {
    $('#tabla-obras-sociales').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "/obras-sociales",
            "type": "GET",
            "error": function(xhr, error, thrown) {
                console.error('Error en DataTable:', error);
            }
        },
        "columns": [
            {data: 'id'},
            {data: 'nombre'},
            {data: 'cuit'},
            {data: 'fecha_convenio'},
            {data: 'fecha_vencimiento_convenio'},
            {
                data: 'id',
                render: function(data) {
                    return `
                        <button class="btn btn-warning btn-sm" onclick="editarObraSocial(${data})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarObraSocial(${data})">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-info btn-sm" onclick="verProductos(${data})">
                            <i class="fas fa-pills"></i> Ver Productos
                        </button>
                    `;
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
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




