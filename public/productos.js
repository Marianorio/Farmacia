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
 );