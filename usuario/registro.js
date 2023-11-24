$(Document).ready(function () {
    $('#botonRegistro').click(function () {
        var nombre = $('#inputNombreRegistro').val();
        var apellidos = $('#inputApellidosRegistro').val();
        var dni = $('#inputDniRegistro').val();
        var telefono = $('#inputTelefonoRegistro').val();
        var cp = $('#inputCpRegistro').val();
        var email = $('#inputEmailRegistro').val();
        var usuario = $('#inputUsuario').val();
        var password = $('#inputContraseña').val();

        // Validamos los datos
        if (nombre === '' || apellidos === '' || dni === '' || telefono === '' || cp === '' || email === '' || usuario === '' || password === '') {
            alert('Todos los campos son obligatorios');
            return;
        }
        // Validación para el DNI
        var dniRegex = /^[0-9]{8}[A-HJ-NP-TV-Za-hj-np-tv-z]$/; // Regex para validar DNI españoles
        if(!dniRegex.test(dni)){
            alert('Error, el DNI no es válido');
            return;
        }
        // Validación para email
        var emailRegex = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;
        if(!emailRegex.test(email)){
            alert('El correo electrónico no es válido');
            return;
        }

        // Enviamos los datos al servidor mediante AJAX
        $.ajax({
            type: 'POST',
            URL: 'registro.php',
            data: {
                nombre: nombre,
                apellidos: apellidos,
                dni: dni,
                telefono: telefono,
                cp: cp,
                email: email,
                usuario: usuario,
                contraseña: password
            },
            success: function(response){
                alert(response);
            },
            error: function (error) {
                alert('Error al registrar al usuario');
            }
        }); 

    });
});