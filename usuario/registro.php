<?php
include_once "../Conexion.php";

if (isset($_POST['botonRegistro'])) {
    // Recuperamos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];rgteghegergrgregregregregergergerg
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $cp = $_POST['cp'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Validamos los datos recuperados
    if (empty($nombre) || empty($apellidos) || empty($dni) || empty($telefono) || empty($cp) || empty($email) || empty($usuario) || empty($password)) {
        echo 'Todos los campos son obligatorios';
        exit();
    }

    // Validación DNI
    $dniRegex = '/^[0-9]{8}[A-HJ-NP-TV-Za-hj-np-tv-z]$/';
    if (!preg_match($dniRegex, $dni)) {
        echo 'El DNI no es válido';
        exit();
    }

    // Validación correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'El correo electrónico no es válido';
        exit();
    }

    // Verificar si el usuario ya existe
    $sqlVerificarUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmtVerificarUsuario = $conn->prepare($sqlVerificarUsuario);
    $stmtVerificarUsuario->bindParam(':usuario', $usuario);
    $stmtVerificarUsuario->execute();

    // Comprobar si ya existe el usuario
    if ($stmtVerificarUsuario->rowCount() > 0) {
        echo "Este usuario ya ha sido registrado en la base de datos.";
    } else {
        try {
            // Preparar la consulta de inserción
            $sqlInsercion = "INSERT INTO usuarios (nombre, apellidos, dni, telefono, cp, email, usuario, password) VALUES (:nombre, :apellidos, :dni, :telefono, :cp, :email, :usuario, :password)";

            // Preparar la consulta
            $stmtInsercion = $conn->prepare($sqlInsercion);

            // Vincular parámetros
            $stmtInsercion->bindParam(':nombre', $nombre);
            $stmtInsercion->bindParam(':apellidos', $apellidos);
            $stmtInsercion->bindParam(':dni', $dni);
            $stmtInsercion->bindParam(':telefono', $telefono);
            $stmtInsercion->bindParam(':cp', $cp);
            $stmtInsercion->bindParam(':email', $email);
            $stmtInsercion->bindParam(':usuario', $usuario);
            $stmtInsercion->bindParam(':password', $password);

            // Ejecutar la consulta
            $stmtInsercion->execute();

            echo 'Has sido registrado!';
            header('Location: login.php');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicio</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="./registro.js"></script>
</head>

<body id="bodyLogin">

    <section class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center" style="width: 27rem;">
            <div class="card-body">
                <div class="card-title">
                    <i class="fas fa-paw"></i>
                    <h2 class="text-primary">Bienvenid@ a nuestra Protectora</h2>
                </div>
                <form class="container" action="" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="inputNombreRegistro" placeholder="Nombre" name="nombre">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="inputApellidosRegistro" placeholder="Apellidos" name="apellidos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="inputDniRegistro" placeholder="DNI" name="dni">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="inputTelefonoRegistro" placeholder="Teléfono" name="telefono">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="inputCpRegistro" placeholder="CP" name="cp">
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="inputEmailRegistro" placeholder="Email" name="email">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="inputUsuario" placeholder="Usuario" name="usuario">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="inputContraseña" placeholder="Contraseña" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary" id="botonRegistro" name="botonRegistro">Registrarse</button>
                </form>
            </div>
        </div>
    </section>

</body>

</html>