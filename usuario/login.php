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
        <div class="card text-center" style="width: 22rem;">
            <div class="card-body">
                <div class="card-title">
                    <i class="fas fa-paw"></i>
                    <h2 class="text-primary">Bienvenid@ a nuestra Protectora</h2>
                </div>
                <form class="" action="" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="inputUsuario" placeholder="Usuario">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="inputContraseña" placeholder="Contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary" id="botonLogin">Iniciar Sesión</button>
                </form>
            </div>
            <div class="card-footer text-muted">
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a> </p>
            </div>
        </div>
    </section>

</body>

</html>