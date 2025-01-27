<script>
    function agregarPropietario() {
        // Recopila los datos de los campos sueltos
        var data = {
            nombre: $('#pro_nombre').val(),
            apellido: $('#pro_apellido').val(),
            email: $('#pro_email').val(),
            telefono: $('#pro_telefono').val(),
            direccion: $('#pro_direccion').val()
        };
        //alert(JSON.stringify(data));
        // Enviar los datos utilizando AJAX
        $.ajax({
            type: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            url: '{{ route('adm.propiedades.propietario.store') }}', // La URL de la ruta en Laravel
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                alert('Propietario '+response.ultNombre+' agregado correctamente');
                console.log(response);
                //window.location.href = '{{ route('adm.servicios.seguimiento') }}';
                var $combobox = $('#id_propietario');
                var $option = $('<option></option>')
                    .attr('value', response.ultID)
                    .text(response.ultNombre);
                // Agregar la opción al combobox
                $combobox.append($option);

                // Seleccionar la opción recién agregada
                $combobox.val(response.ultID);
                // Aquí puedes agregar cualquier acción adicional en caso de éxito
                $('#modalAgregarPropietario').modal('hide');
            },
            error: function(error) {
                alert('Hubo un error al enviar los datos');
                console.error(error);
                $('#frmAgregarPropietario input').removeClass('is-invalid');
                if (error.status === 422) {
                    var errors = error.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#pro_' + key).addClass('is-invalid');
                        $('#error-' + key).text(value[0]);
                    });
                }
                // Aquí puedes manejar el error
            }
        });
    }
    //Propietarios
    /*function abrirPropietario() {
        $('#modalAgregarPropietario').modal('show');
    }*/
    function abrirPropietario(event) {
        event.preventDefault(); // Previene que el botón envíe el formulario
        $('#modalAgregarPropietario').modal('show');
    }

</script>