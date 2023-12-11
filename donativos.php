<?php
include_once "Conexion.php";
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: usuario/login.php");
    exit();
}

// Obtener datos del usuario actual
$idUsuario = $_SESSION['id_usuario'];
$stmtUsuario = $conn->prepare("SELECT * FROM usuarios WHERE id = :id_usuario");
$stmtUsuario->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmtUsuario->execute();
$datosUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);


$stmtSocio = $conn->prepare("SELECT * FROM socios WHERE id_usuario = :id_usuario");
$stmtSocio->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmtSocio->execute();
$datosSocios = $stmtSocio->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['realizarDonativo'])) {
    $fecha = date("Y-m-d");
    $tipo = $_POST['tipoDonativo'];
    $cantidad = $_POST['cantidad'];
    

    $stmtInsertarVoluntario = $conn->prepare("INSERT INTO donativos (fecha, tipo, cantidad, id_usuario) VALUES (:fecha, :tipo, :cantidad, :idUsuario)");

    $stmtInsertarVoluntario->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmtInsertarVoluntario->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $stmtInsertarVoluntario->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
    $stmtInsertarVoluntario->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

    if ($stmtInsertarVoluntario->execute()) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: donativos.php?error=insertar_fallo");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Donativos</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="./js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php"><img src="./imagenes/logo.png" width="50px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./sobreNosotros.php">Sobre nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./adoptar.php">Adoptar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./colabora.php">Colabora</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contactenos.php">Contáctenos</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($usuario)) : ?>
                            <!-- Si hay una sesión activa, muestra el logotipo de usuario y la opción de cerrar sesión -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user"></i> <?php echo $usuario; ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                                    <a class="dropdown-item" href="#">Mi Perfil</a>
                                    <a class="dropdown-item" href="#">Configuración</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="./usuario/logout.php">Cerrar Sesión</a>
                                </div>
                            </li>
                        <?php else : ?>
                            <!-- Si no hay una sesión activa, muestra la opción de iniciar sesión -->
                            <li class="nav-item">
                                <a class="nav-link" href="usuario/login.php"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h1 class="text-center">¡Haz tu donativo!</h1>
        <form method="post" action="donativos.php" class="row">
            <!-- Columna izquierda -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $datosUsuario['nombre']; ?>" readonly required>
                </div>

                <div class="mb-3">
                    <label for="dni" class="form-label">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $datosUsuario['dni']; ?>" readonly required>
                </div>
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                </div>

            </div>

            <!-- Columna derecha -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $datosUsuario['apellidos']; ?>" readonly required>
                </div>

                <div class="mb-3">
                    <label for="iban" class="form-label">IBAN:</label>
                    <input type="text" class="form-control" id="iban" name="iban" value="<?php echo $datosSocios['iban']; ?>" readonly required>
                </div>

                <div class="mb-3">
                    <label for="tipoDonativo" class="form-label">Tipo de Donativo:</label>
                    <select class="form-select" id="tipoDonativo" name="tipoDonativo" required>
                        <option value="efectivo">Efectivo</option>
                        <option value="paypal">Paypal</option>
                        <option value="tarjeta">Tarjeta de crédito/débito</option>
                        <option value="cheque">Cheque</option>
                        <option value="transferencia">Transferencia bancaria</option>
                    </select>
                </div>

                <!-- Input hidden para el id_usuario -->
                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">


                <button type="submit" name="realizarDonativo" id="realizarDonativo" class="btn btn-primary">Realizar Donativo</button>
            </div>
        </form>
    </div>


    <!------------------------------ FOOTER -------------------------------->
    <footer class="text-center text-white" style="background-color: #6db1bf;">
        <div class="container-fluid p-5" id="footerPart1">
            <div class="row">
                <!-- Redes Sociales -->
                <div class="col-lg-4">
                    <h4>Síguenos en redes sociales</h4>
                    <div class="social-buttons">
                        <!-- Facebook -->
                        <a class="btn btn-floating m-1" style="background-color: #3b5998;" href="https://es-es.facebook.com/" role="button">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <!-- Twitter -->
                        <a class="btn btn-floating m-1" style="background-color: #3b5998;" href="https://twitter.com/?lang=es" role="button">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <!-- Instagram -->
                        <a class="btn btn-floating m-1" style="background-color: #3b5998;" href="https://www.instagram.com/" role="button">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <!-- Google -->
                        <a class="btn btn-floating m-1" style="background-color: #3b5998;" href="https://www.google.com/intl/es/gmail/about/" role="button">
                            <i class="fab fa-google"></i>
                        </a>
                    </div>
                </div>
                <!-- Páginas de la Protectora -->
                <div class="col-lg-4">
                    <h4 class="">Páginas</h4>
                    <ul class="list-unstyled ">
                        <li><a href="#" class="text-white text-decoration-none"><i class="fas fa-home me-3"></i> Inicio</a></li>
                        <li><a href="#" class="text-white text-decoration-none"><i class="fas fa-paw me-3"></i> Adopciones</a></li>
                        <li><a href="#" class="text-white text-decoration-none"><i class="fas fa-donate me-3"></i> Donaciones</a></li>
                        <li><a href="#" class="text-white text-decoration-none"><i class="fas fa-hands-helping me-3"></i> Voluntariado</a></li>
                    </ul>
                </div>
                <!-- Información de contacto -->
                <div class="col-lg-4">
                    <h4>Contacto</h4>
                    <!-- Ubicación -->
                    <p><i class="fas fa-map-marker-alt me-3"></i><a href="https://www.google.es/maps/@37.5278471,-6.0563723,311m/data=!3m1!1e3" class="text-white text-decoration-none" target="_blank">Dirección</a></p>
                    <!-- Número -->
                    <p><i class="fas fa-phone-alt me-3"></i><a href="#modalTelefono" class="text-white text-decoration-none" role="button" data-bs-toggle="modal" data-bs-target="#modalTelefono">Teléfono</a></p>
                    <!-- Correo -->
                    <p><i class="fas fa-envelope me-3"></i><a href="mailto:info@esperanzaanimal.org" class="text-white text-decoration-none">info@esperanzaanimal.org</a></p>
                </div>
            </div>
        </div>
        <!-- Copyright -->
        <div class="text-center p-3" id="footerPart2">
            © 2023 Copyright: Esperanza Animal
        </div>
    </footer>
</body>

</html>