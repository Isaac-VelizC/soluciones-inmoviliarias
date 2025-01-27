<script>
    function agregarVentaTipo() {
        // Recopila los datos de los campos sueltos
        var data = {
            descripcion: $('#vetipo_descripcion').val(),
            detalle: $('#vetipo_detalle').val()
        };
        // Enviar los datos utilizando AJAX
        $.ajax({
            type: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            url: '{{ route('adm.propiedades.ventatipo.store') }}', // La URL de la ruta en Laravel
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                alert('Tipo de venta '+response.ultDescripcion+' agregado correctamente');
                console.log(response);
                //
                var $combobox = $('#tipo_traspaso');
                var $option = $('<option></option>')
                    .attr('value', response.ultID)
                    .text(response.ultDescripcion);
                //Agregar la opción al combobox
                $combobox.append($option);

                // Seleccionar la opción recién agregada
                $combobox.val(response.ultID);
                // Aquí puedes agregar cualquier acción adicional en caso de éxito
                $('#modalAgregarVentaTipo').modal('hide');
            },
            error: function(error) {
                alert('Hubo un error al enviar los datos');
                console.error(error);
                $('#frmAgregarVentaTipo input').removeClass('is-invalid');
                if (error.status === 422) {
                    var errors = error.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#vetipo_' + key).addClass('is-invalid');
                        $('#error-' + key).text(value[0]);
                    });
                }
                // Aquí puedes manejar el error
            }
        });
    }
    //Propietarios
    function abrirVentaTipo(event) {
        event.preventDefault();
        $('#modalAgregarVentaTipo').modal('show');
    }
</script>
