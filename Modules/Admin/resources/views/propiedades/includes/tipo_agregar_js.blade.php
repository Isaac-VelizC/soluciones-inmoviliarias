<script>
    function agregarTipo() {
        // Recopila los datos de los campos sueltos
        var data = {
            descripcion: $('#tipo_descripcion').val(),
            detalle: $('#tipo_detalle').val(),
        };
        //alert(JSON.stringify(data));
        // Enviar los datos utilizando AJAX
        $.ajax({
            type: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            url: '{{ route('adm.propiedades.tipo.store') }}', // La URL de la ruta en Laravel
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                alert('Tipo de propiedad '+response.ultDescripcion+' agregado correctamente');
                console.log(response);
                //
                var $combobox = $('#tipo_propiedad');
                var $option = $('<option></option>')
                    .attr('value', response.ultID)
                    .text(response.ultDescripcion);
                // Agregar la opción al combobox
                $combobox.append($option);

                // Seleccionar la opción recién agregada
                $combobox.val(response.ultID);
                // Aquí puedes agregar cualquier acción adicional en caso de éxito
                $('#modalAgregarTipo').modal('hide');
            },
            error: function(error) {
                alert('Hubo un error al enviar los datos');
                console.error(error);
                $('#frmAgregarTipoPropiedad input').removeClass('is-invalid');
                if (error.status === 422) {
                    var errors = error.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#tipo_' + key).addClass('is-invalid');
                        $('#error-' + key).text(value[0]);
                    });
                }
                // Aquí puedes manejar el error
            }
        });
    }
    //Propietarios
    function abrirTipo(event) {
        event.preventDefault();
        $('#modalAgregarTipo').modal('show');
    }
</script>
