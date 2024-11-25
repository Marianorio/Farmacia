document.addEventListener('DOMContentLoaded', function() {
    // Modal para nuevo proveedor
    const btnNuevoProveedor = document.querySelector('.btn-primary');
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
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
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

    // Ver productos (usando jQuery para mantener la compatibilidad con DataTables)
    $(document).on('click', '.ver-productos', function() {
        const id = $(this).data('id');
        console.log('ID del proveedor:', id); // Debug

        $.ajax({
            url: `/proveedores/${id}/productos`,
            type: 'GET',
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Debug
                let html = '';
                
                if (!response.productos || response.productos.length === 0) {
                    html = '<div class="alert alert-info">Este proveedor no tiene productos asociados.</div>';
                } else {
                    html = `
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio Compra</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    response.productos.forEach(producto => {
                        html += `
                            <tr>
                                <td>${producto.nombre}</td>
                                <td>${producto.categoria ? producto.categoria.nombre : 'Sin categoría'}</td>
                                <td>$${producto.precio_compra}</td>
                                <td>${producto.stock_actual}</td>
                            </tr>
                        `;
                    });

                    html += '</tbody></table>';
                }
                
                console.log('HTML generado:', html); // Debug
                $('#productos-por-categoria').html(html);
                $('#modalProductosProveedor').modal('show');
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                Swal.fire('Error', 'No se pudieron cargar los productos', 'error');
            }
        });
    });
});