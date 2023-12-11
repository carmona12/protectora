function validarFormularioRegistro() {
    var nombre = document.getElementById("inputNombreRegistro").value;
    var apellidos = document.getElementById("inputApellidosRegistro").value;
    var dni = document.getElementById("inputDniRegistro").value;
    var telefono = document.getElementById("inputTelefonoRegistro").value;
    var cp = document.getElementById("inputCpRegistro").value;
    var email = document.getElementById("inputEmailRegistro").value;
    var usuario = document.getElementById("inputUsuario").value;
    var password = document.getElementById("inputContraseña").value;

    // Validamos los datos
    if (nombre === "" || apellidos === "" || dni === "" || telefono === "" || cp === "" || email === "" || usuario === "" || password === "") {
        alert('Por favor, complete todos los campos.');
        return false;
    }

    // Validación para el DNI
    var dniRegex = /^[0-9]{8}[A-HJ-NP-TV-Za-hj-np-tv-z]$/; // Regex para validar DNI españoles
    if (!dniRegex.test(dni)) {
        alert('Por favor, ingrese un DNI válido.');
        return false;
    }

    // Validación para teléfono
    var telefonoRegex = /^\d{9}$/;
    if(!telefonoRegex.test(telefono)){
        alert('Por favor, ingrese un número de teléfono válido.');
        return false;
    }

    // Validación para email
    var emailRegex = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;
    if(!emailRegex.test(email)){
        alert('Por favor, ingrese un correo electrónico válido.');
        return false;
    }
}