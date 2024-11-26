document.addEventListener('DOMContentLoaded', function() {
    // Modal para nuevo proveedor
    const btnNuevoProveedor = document.querySelector('.btn-nuevo-proveedor');
    const proveedorForm = document.getElementById('proveedorForm');
    
    if (btnNuevoProveedor) {
        btnNuevoProveedor.addEventListener('click', function() {
            $('#modalProveedor').modal('show');
            if (proveedorForm) {
                proveedorForm.reset();
            }
        });
    }

    // Manejar el envío del formulario
    if (proveedorForm) {
        proveedorForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Formulario enviado'); // Debug
            
            const formData = new FormData(this);
            
            // Log de los datos que se van a enviar
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]); // Debug
            }

            fetch('/proveedores', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                console.log('Respuesta status:', response.status); // Debug
                return response.json();
            })
            .then(data => {
                console.log('Respuesta data:', data); // Debug
                
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Proveedor guardado correctamente',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    $('#modalProveedor').modal('hide');
                    if (proveedorForm) {
                        proveedorForm.reset();
                    }
                    window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error completo:', error); // Debug
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al crear el proveedor',
                    icon: 'error'
                });
            });
        });
    } else {
        console.error('No se encontró el formulario con ID "proveedorForm"'); // Debug
    }

    // Manejar el clic en el botón "Ver Productos"
    $(document).on('click', '.ver-productos', function() {
        const id = $(this).data('id');
        const proveedorNombre = $(this).closest('tr').find('td:eq(1)').text(); // Obtiene el nombre del proveedor

        // Mostrar loading
        Swal.fire({
            title: 'Cargando productos...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Hacer la petición AJAX
        $.ajax({
            url: `/proveedores/${id}/productos`,
            method: 'GET',
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    let html = '';
                    const productos = response.productos;

                    // Agrupar productos por categoría
                    const productosPorCategoria = {};
                    productos.forEach(producto => {
                        const categoria = producto.categoria ? producto.categoria.nombre : 'Sin Categoría';
                        if (!productosPorCategoria[categoria]) {
                            productosPorCategoria[categoria] = [];
                        }
                        productosPorCategoria[categoria].push(producto);
                    });

                    // Generar HTML para cada categoría
                    for (const categoria in productosPorCategoria) {
                        html += `
                            <h4 class="mt-3">${categoria}</h4>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Precio Compra</th>
                                        <th>Precio Venta</th>
                                        <th>Stock Actual</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        productosPorCategoria[categoria].forEach(producto => {
                            html += `
                                <tr>
                                    <td>${producto.nombre}</td>
                                    <td>${producto.descripcion || '-'}</td>
                                    <td>$${producto.precio_compra}</td>
                                    <td>$${producto.precio_venta}</td>
                                    <td>
                                        <span class="badge badge-${producto.stock_actual > producto.stock_minimo ? 'success' : 'danger'}">
                                            ${producto.stock_actual}
                                        </span>
                                    </td>
                                </tr>
                            `;
                        });

                        html += '</tbody></table>';
                    }

                    // Si no hay productos
                    if (Object.keys(productosPorCategoria).length === 0) {
                        html = '<div class="alert alert-info">Este proveedor no tiene productos registrados.</div>';
                    }

                    // Actualizar título del modal y contenido
                    $('#modalProductosProveedor .modal-title').text(`Productos de ${proveedorNombre}`);
                    $('#productos-por-categoria').html(html);
                    $('#modalProductosProveedor').modal('show');
                }
            },
            error: function(xhr) {
                Swal.close();
                Swal.fire('Error', 'No se pudieron cargar los productos', 'error');
                console.error('Error:', xhr);
            }
        });
    });
});