// Agregar estas funciones al inicio del archivo
function cargarCategorias() {
    $.get('/categorias', function(response) {
        let options = '<option value="">Seleccione una categoría</option>';
        response.forEach(function(categoria) {
            options += `<option value="${categoria.id}">${categoria.nombre}</option>`;
        });
        $('#id_categoria').html(options);
    });
}

function cargarObrasSociales() {
    $.get('/obras-sociales', function(response) {
        let options = '<option value="">Seleccione una obra social</option>';
        response.forEach(function(obraSocial) {
            options += `<option value="${obraSocial.id}">${obraSocial.nombre}</option>`;
        });
        $('#obra_social_id').html(options);
        
        // Inicializar Select2
        $('#obra_social_id').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: 'Seleccione una obra social'
        });
    });
}

function nuevoProducto() {
    // Limpiar formulario
    $('#formProducto')[0].reset();
    $('#id').val('');
    
    // Resetear categoría
    $('#id_categoria').val('').trigger('change');
    
    // Limpiar contenedor de coberturas
    $('#coberturas_container').empty();
    
    // Cargar datos necesarios
    cargarCategorias();
    cargarObrasSociales();
    
    // Mostrar el modal
    $('#modalProducto').modal('show');
}

$(document).ready(function() {
    $('#tabla-productos').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/productos',
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 'categoria.nombre' },
            { data: 'precio_compra' },
            { data: 'precio_venta' },
            { data: 'stock_inicial' },
            { data: 'stock_actual' },
            { data: 'stock_minimo' },
            { data: 'caducidad' },
            { 
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm ver-producto" data-id="${row.id}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary btn-sm editar-producto" data-id="${row.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm eliminar-producto" data-id="${row.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    // Inicializar Select2 para categorías y obras sociales
    $('#id_categoria, #obra_social_id').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Inicializar Select2 para obras sociales
    $('#obra_social_id').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Seleccione las obras sociales',
        allowClear: true
    });

    // Manejar cambios en la selección de obras sociales
    $('#obra_social_id').on('change', function() {
        const obraSocialId = $(this).val();
        const obraSocialText = $(this).find('option:selected').text();
        
        if (obraSocialId) {
            const porcentaje = $('#porcentaje_cobertura').val();
            
            if (!porcentaje || porcentaje < 0 || porcentaje > 100) {
                Swal.fire('Error', 'Por favor ingrese un porcentaje válido entre 0 y 100', 'error');
                return;
            }
            
            // Verificar si la obra social ya fue agregada
            if ($(`#cobertura_${obraSocialId}`).length > 0) {
                Swal.fire('Error', 'Esta obra social ya fue agregada', 'error');
                return;
            }
            
            // Agregar la cobertura a la tabla
            $('#tabla-coberturas').append(`
                <tr id="cobertura_${obraSocialId}">
                    <td>${obraSocialText}</td>
                    <td>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control cobertura-input" 
                                   name="coberturas[${obraSocialId}]" 
                                   value="${porcentaje}"
                                   readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="eliminarCobertura(${obraSocialId})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            
            // Limpiar los campos
            $(this).val('').trigger('change');
            $('#porcentaje_cobertura').val('');
        }
    });

    // Manejar el envío del formulario
    $('#formProducto').on('submit', function(e) {
        e.preventDefault();
        
        // Validar que se hayan ingresado los porcentajes
        let porcentajesValidos = true;
        $('.cobertura-input').each(function() {
            const valor = $(this).val();
            if (!valor || valor < 0 || valor > 100) {
                porcentajesValidos = false;
                return false; // rompe el loop
            }
        });

        if (!porcentajesValidos) {
            Swal.fire('Error', 'Por favor, ingrese porcentajes válidos (entre 0 y 100) para todas las obras sociales seleccionadas', 'error');
            return;
        }

        const formData = new FormData(this);
        const id = $('#id').val();
        const url = id ? `/productos/${id}` : '/productos';
        
        if (id) {
            formData.append('_method', 'PUT');
        }

        // Recolectar datos de coberturas
        const coberturas = {};
        $('.cobertura-input').each(function() {
            const obraSocialId = $(this).attr('name').match(/\d+/)[0];
            coberturas[obraSocialId] = $(this).val();
        });
        
        console.log('Coberturas a enviar:', coberturas); // Para debug
        formData.append('coberturas', JSON.stringify(coberturas));

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Para debug
                $('#modalProducto').modal('hide');
                $('#tabla-productos').DataTable().ajax.reload();
                Swal.fire('¡Éxito!', response.message, 'success');
            },
            error: function(xhr) {
                console.error('Error del servidor:', xhr); // Para debug
                Swal.fire('Error', xhr.responseJSON?.message || 'Error al guardar el producto', 'error');
            }
        });
    });
});

// Manejadores de eventos para los botones
$(document).on('click', '.ver-producto', function() {
    const id = $(this).data('id');
    console.log('Ver producto:', id); // Para debug
    
    $.get(`/productos/${id}`, function(response) {
        const producto = response.data;
        
        let obrasSocialesHtml = '';
        if (producto.obras_sociales && producto.obras_sociales.length > 0) {
            obrasSocialesHtml = `
                <h6 class="mt-3">Coberturas de Obras Sociales:</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Obra Social</th>
                            <th>Cobertura</th>
                            <th>Precio Final</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            producto.obras_sociales.forEach(function(os) {
                const descuento = parseFloat(os.pivot.descuento);
                const precioOriginal = parseFloat(producto.precio_venta);
                const descuentoMonto = (precioOriginal * descuento) / 100;
                const precioFinal = precioOriginal - descuentoMonto;
                
                obrasSocialesHtml += `
                    <tr>
                        <td>${os.nombre}</td>
                        <td>${descuento}%</td>
                        <td>$${precioFinal.toFixed(2)} 
                            <small class="text-muted">
                                (Descuento: $${descuentoMonto.toFixed(2)})
                            </small>
                        </td>
                    </tr>
                `;
            });
            
            obrasSocialesHtml += `
                    </tbody>
                </table>
            `;
        }

        Swal.fire({
            title: producto.nombre,
            html: `
                <div class="text-left">
                    <p><strong>Categoría:</strong> ${producto.categoria?.nombre || 'Sin categoría'}</p>
                    <p><strong>Descripción:</strong> ${producto.descripcion || 'Sin descripción'}</p>
                    <p><strong>Precio Compra:</strong> $${producto.precio_compra}</p>
                    <p><strong>Precio Venta:</strong> $${producto.precio_venta}</p>
                    <p><strong>Stock Actual:</strong> ${producto.stock_actual}</p>
                    <p><strong>Stock Mínimo:</strong> ${producto.stock_minimo}</p>
                    <p><strong>Fecha Caducidad:</strong> ${producto.caducidad || 'No especificada'}</p>
                    ${obrasSocialesHtml}
                </div>
            `,
            width: '800px',
            customClass: {
                container: 'custom-swal-container'
            }
        });
    });
});

$(document).on('click', '.eliminar-producto', function() {
    const id = $(this).data('id');
    console.log('Eliminar producto:', id); // Para debug
    
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
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#tabla-productos').DataTable().ajax.reload();
                    Swal.fire(
                        '¡Eliminado!',
                        'El producto ha sido eliminado.',
                        'success'
                    );
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error',
                        'No se pudo eliminar el producto.',
                        'error'
                    );
                }
            });
        }
    });
});

// Función para eliminar una cobertura
function eliminarCobertura(obraSocialId) {
    $(`#cobertura_${obraSocialId}`).remove();
}

// Agregar el manejador para el botón editar
$(document).on('click', '.editar-producto', function() {
    const id = $(this).data('id');
    
    // Limpiar formulario y tabla de coberturas
    $('#formProducto')[0].reset();
    $('#tabla-coberturas').empty();
    
    // Cargar datos necesarios
    cargarCategorias();
    cargarObrasSociales();
    
    // Obtener datos del producto
    $.get(`/productos/${id}`, function(response) {
        const producto = response.data;
        
        // Llenar campos del formulario
        $('#id').val(producto.id);
        $('#nombre').val(producto.nombre);
        $('#descripcion').val(producto.descripcion);
        $('#precio_compra').val(producto.precio_compra);
        $('#precio_venta').val(producto.precio_venta);
        $('#stock_inicial').val(producto.stock_inicial);
        $('#stock_actual').val(producto.stock_actual);
        $('#stock_minimo').val(producto.stock_minimo);
        $('#caducidad').val(producto.caducidad);
        $('#id_categoria').val(producto.id_categoria).trigger('change');
        
        // Cargar coberturas existentes
        if (producto.obras_sociales && producto.obras_sociales.length > 0) {
            producto.obras_sociales.forEach(function(obraSocial) {
                $('#tabla-coberturas').append(`
                    <tr id="cobertura_${obraSocial.id}">
                        <td>${obraSocial.nombre}</td>
                        <td>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control cobertura-input" 
                                       name="coberturas[${obraSocial.id}]" 
                                       value="${obraSocial.pivot.descuento}"
                                       readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="eliminarCobertura(${obraSocial.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }
        
        // Actualizar título del modal
        $('#modalProductoLabel').text('Editar Producto');
        
        // Mostrar modal
        $('#modalProducto').modal('show');
    }).fail(function(xhr) {
        console.error('Error al cargar el producto:', xhr);
        Swal.fire('Error', 'No se pudo cargar el producto', 'error');
    });
});
