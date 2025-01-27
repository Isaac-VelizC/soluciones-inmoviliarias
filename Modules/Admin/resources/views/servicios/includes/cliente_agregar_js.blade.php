<script>
    function agregarCliente() {
        var token = $('meta[name="csrf-token"]').attr('content');
        // Recopila los datos de los campos sueltos
        var data = {
            nombre: $('#cli_nombre').val(),
            apellido: $('#cli_apellido').val(),
            email: $('#cli_email').val(),
            telefono: $('#cli_telefono').val(),
        };
        
        //alert(JSON.stringify(data));
        // Enviar los datos utilizando AJAX
        $.ajax({
            type: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            url: '{{ route('citas.servicios.cliente.store') }}', // La URL de la ruta en Laravel
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                alert('Cliente '+response.ultNombre+' agregado correctamente');
                console.log(response);
                //window.location.href = '{{ route('adm.servicios.seguimiento') }}';
                var $combobox = $('#id_usuario');
                var $option = $('<option></option>')
                    .attr('value', response.ultID)
                    .text(response.ultNombre);
                // Agregar la opción al combobox
                $combobox.append($option);

                // Seleccionar la opción recién agregada
                $combobox.val(response.ultID);
                // Aquí puedes agregar cualquier acción adicional en caso de éxito
                $('#modalAgregarCliente').modal('hide');
            },
            error: function(error) {
                alert('Hubo un error al enviar los datos');
                console.error(error);
                $('#frmAgregarCliente input').removeClass('is-invalid');
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
    function abrirCliente(event) {
        event.preventDefault(); // Previene que el botón envíe el formulario
        $('#modalAgregarCliente').modal('show');
    }

</script>