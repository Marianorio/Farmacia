$(document).ready(function() {
    // Inicializar Select2
    $('.select2').select2({
        placeholder: 'Seleccione las obras sociales',
        allowClear: true
    });

    // Manejar cambios en la selección de obras sociales
    $('#obras_sociales').on('change', function() {
        actualizarCamposDescuento();
    });

    // Verificar alertas al cargar la página
    verificarAlertasGenerales();

    // Cuando cambia el stock inicial, actualizar el stock actual
    $('#stock_inicial').on('change', function() {
        if (!$('#formProducto').data('editing')) {  // Si es un nuevo producto
            $('#stock_actual').val($(this).val());
        }
    });

    verificarAlertas();
});

function actualizarCamposDescuento() {
    let selectedOptions = $('#obras_sociales').val();
    let container = $('#descuentos_container');
    container.empty();

    if (selectedOptions) {
        selectedOptions.forEach(function(obraSocialId) {
            let obraSocialNombre = $('#obras_sociales option[value="' + obraSocialId + '"]').text();
            container.append(`
                <div class="form-group">
                    <label>Descuento para ${obraSocialNombre} (%)</label>
                    <input type="number" 
                           class="form-control" 
                           name="descuentos[${obraSocialId}]" 
                           min="0" 
                           max="100" 
                           required>
                </div>
            `);
        });
    }
}

function verObrasSociales(productoId) {
    $.get(`/productos/${productoId}/coberturas`, function(response) {
        let html = '';
        response.coberturas.forEach(function(cobertura) {
            const precioFinal = response.precio_venta * (1 - cobertura.descuento/100);
            html += `
                <tr>
                    <td>${cobertura.nombre}</td>
                    <td>${cobertura.descuento}%</td>
                    <td>$${precioFinal.toFixed(2)}</td>
                </tr>
            `;
        });
        $('#tabla-coberturas').html(html);
        $('#modalCoberturas').modal('show');
    });
}

function guardarProducto() {
    // Validaciones básicas
    if (!$('#nombre').val()) {
        Swal.fire('Error', 'El nombre del producto es requerido', 'error');
        return;
    }

    if (!$('#stock_inicial').val()) {
        Swal.fire('Error', 'El stock inicial es requerido', 'error');
        return;
    }

    // Obtener todos los datos del formulario
    let formData = new FormData(document.getElementById('formProducto'));
    
    // Validar que el stock inicial sea un número válido
    const stockInicial = parseInt($('#stock_inicial').val());
    if (isNaN(stockInicial) || stockInicial < 0) {
        Swal.fire('Error', 'El stock inicial debe ser un número válido mayor o igual a 0', 'error');
        return;
    }

    // Si es un nuevo producto, el stock actual debe ser igual al inicial
    if (!formData.get('id')) {  // Si es nuevo producto
        formData.set('stock_actual', stockInicial);
    }

    $.ajax({
        url: '/productos',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#modalProducto').modal('hide');
                $('#formProducto').trigger('reset');
                Swal.fire('¡Éxito!', response.message, 'success');
                location.reload();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function(xhr) {
            let errorMessage = 'Hubo un error al guardar el producto';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
            }
            Swal.fire('Error', errorMessage, 'error');
        }
    });
}

function validarFormulario() {
    const precio_compra = parseFloat($('#precio_compra').val());
    const precio_venta = parseFloat($('#precio_venta').val());
    const stock_actual = parseInt($('#stock_actual').val());
    const stock_minimo = parseInt($('#stock_minimo').val());
    const caducidad = new Date($('#caducidad').val());
    const hoy = new Date();

    if (precio_venta <= precio_compra) {
        Swal.fire('Error', 'El precio de venta debe ser mayor al precio de compra', 'error');
        return false;
    }

    if (stock_minimo < 0) {
        Swal.fire('Error', 'El stock mínimo no puede ser negativo', 'error');
        return false;
    }

    if (stock_actual < 0) {
        Swal.fire('Error', 'El stock actual no puede ser negativo', 'error');
        return false;
    }

    if (caducidad < hoy) {
        Swal.fire('Advertencia', '¡El producto ya está vencido!', 'warning');
    }

    return true;
}

// Función para verificar stock y caducidad
function verificarAlertasProducto(producto) {
    let alertas = [];
    
    if (producto.stock_actual <= producto.stock_minimo) {
        alertas.push(`Stock bajo: ${producto.stock_actual} unidades (mínimo: ${producto.stock_minimo})`);
    }

    const caducidad = new Date(producto.caducidad);
    const hoy = new Date();
    const treintaDias = new Date();
    treintaDias.setDate(treintaDias.getDate() + 30);

    if (caducidad < hoy) {
        alertas.push(`¡Producto VENCIDO desde ${producto.caducidad}!`);
    } else if (caducidad <= treintaDias) {
        alertas.push(`Próximo a vencer: ${producto.caducidad}`);
    }

    return alertas;
}

function verificarAlertasGenerales() {
    $.get('/productos/alertas', function(response) {
        if (response.alertas && response.alertas.length > 0) {
            let mensaje = '<ul>';
            response.alertas.forEach(function(alerta) {
                mensaje += `<li>${alerta}</li>`;
            });
            mensaje += '</ul>';

            Swal.fire({
                title: '¡Atención!',
                html: mensaje,
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
        }
    });
}

// Modificar la función de editar para marcar el formulario
function editarProducto(id) {
    $('#formProducto').data('editing', true);
    // ... resto del código de edición ...
}

// Modificar la función de abrir el modal para nuevo producto
function nuevoProducto() {
    $('#formProducto').data('editing', false);
    $('#formProducto').trigger('reset');
    $('#modalProducto').modal('show');
}

function verificarAlertas() {
    $.get('/productos/alertas')
        .done(function(response) {
            if (response.success && response.alertas.length > 0) {
                let mensajeHtml = '<ul class="list-unstyled">';
                
                response.alertas.forEach(function(alerta) {
                    let iconoClase = '';
                    switch(alerta.tipo) {
                        case 'stock_bajo':
                            iconoClase = 'fas fa-exclamation-triangle text-warning';
                            break;
                        case 'sin_stock':
                            iconoClase = 'fas fa-times-circle text-danger';
                            break;
                        case 'por_vencer':
                            iconoClase = 'fas fa-clock text-warning';
                            break;
                        case 'vencido':
                            iconoClase = 'fas fa-ban text-danger';
                            break;
                    }
                    
                    mensajeHtml += `
                        <li class="mb-2">
                            <i class="${iconoClase} mr-2"></i>
                            ${alerta.mensaje}
                        </li>`;
                });
                
                mensajeHtml += '</ul>';

                Swal.fire({
                    title: '¡Atención!',
                    html: mensajeHtml,
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
            }
        })
        .fail(function(xhr) {
            console.error('Error al verificar alertas:', xhr);
        });
}
