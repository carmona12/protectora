<?php
include_once "../Conexion.php";
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
                            <input type="text" class="form-control" id="inputNombreRegistro" placeholder="Nombre">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="inputApellidosRegistro" placeholder="Apellidos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="inputDniRegistro" placeholder="DNI">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="inputTelefonoRegistro" placeholder="Teléfono">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="inputCpRegistro" placeholder="CP">
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="inputEmailRegistro" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="inputUsuario" placeholder="Usuario">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="inputContraseña" placeholder="Contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary" id="botonRegistro">Registrarse</button>
                </form>
            </div>
        </div>
    </section>

</body>

</html>