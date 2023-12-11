<?php
include_once "../Conexion.php";

if (isset($_POST['botonRegistro'])) {

    if (!empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["dni"]) && !empty($_POST["telefono"]) && !empty($_POST["cp"]) && !empty($_POST["email"]) && !empty($_POST["usuario"]) && !empty($_POST["password"])) {

        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];
        $cp = $_POST['cp'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Añadir el valor de la columna "rol"
        $rol = "usuario";

        // Verificar si el usuario ya existe
        $sqlVerificarUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmtVerificarUsuario = $conn->prepare($sqlVerificarUsuario);
        $stmtVerificarUsuario->bindParam(':usuario', $usuario);
        $stmtVerificarUsuario->execute();

        if ($stmtVerificarUsuario->rowCount() > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">';
            echo 'El nombre de usuario ya existe, por favor, escoge otro.';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
        } else {

            try {
                $sqlInsertarUsuario = "INSERT INTO usuarios (nombre, apellidos, dni, telefono, cp, email, usuario, password, rol) VALUES (:nombre, :apellidos, :dni, :telefono, :cp, :email, :usuario, :password, :rol)";

                $stmtInsertarUsuario = $conn->prepare($sqlInsertarUsuario);

                $stmtInsertarUsuario->bindParam(':nombre', $nombre);
                $stmtInsertarUsuario->bindParam(':apellidos', $apellidos);
                $stmtInsertarUsuario->bindParam(':dni', $dni);
                $stmtInsertarUsuario->bindParam(':telefono', $telefono);
                $stmtInsertarUsuario->bindParam(':cp', $cp);
                $stmtInsertarUsuario->bindParam(':email', $email);
                $stmtInsertarUsuario->bindParam(':usuario', $usuario);
                $stmtInsertarUsuario->bindParam(':password', $password);
                $stmtInsertarUsuario->bindParam(':rol', $rol);
                $stmtInsertarUsuario->execute();

                echo 'Has sido registrado!';
                header('Location: login.php');
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
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
    <script src="../jquery-3.7.1.min.js"></script>
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
                <form class="container" action="" method="post" onsubmit="return validarFormularioRegistro()">
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