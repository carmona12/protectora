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

// Obtener datos del voluntario actual
$idVoluntario = $_SESSION['id_usuario'];
$stmtVoluntario = $conn->prepare("SELECT * FROM voluntarios WHERE id_usuario = :id_voluntario");
$stmtVoluntario->bindParam(':id_voluntario', $idVoluntario, PDO::PARAM_INT);
$stmtVoluntario->execute();
$datosVoluntario = $stmtVoluntario->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario ya es voluntario
$esVoluntario = ($datosVoluntario !== false);

if (isset($_POST['hacermeVoluntario'])) {
    $areaDeInteres = $_POST['area_de_interes'];
    $disponibilidad = $_POST['disponibilidad'];
    $fechaIngreso = date("Y-m-d");

    $stmtInsertarVoluntario = $conn->prepare("INSERT INTO voluntarios (area_de_interes, disponibilidad, fecha_ingreso, id_usuario) VALUES (:areaDeInteres, :disponibilidad, :fechaIngreso, :idVoluntario)");

    $stmtInsertarVoluntario->bindParam(':areaDeInteres', $areaDeInteres, PDO::PARAM_STR);
    $stmtInsertarVoluntario->bindParam(':disponibilidad', $disponibilidad, PDO::PARAM_STR);
    $stmtInsertarVoluntario->bindParam(':fechaIngreso', $fechaIngreso, PDO::PARAM_STR);
    $stmtInsertarVoluntario->bindParam(':idVoluntario', $idVoluntario, PDO::PARAM_INT);

    if ($stmtInsertarVoluntario->execute()) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: voluntarios.php?error=insertar_fallo");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Voluntarios</title>
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

    <h1 class="text-center">¿Cómo puedo ser voluntario?</h1>
    <div class="container row mb-3">
        <div class="col-md-6">
            <img src="./imagenes/colabora/hazte_voluntario.jpg" width="400px" alt="" class="img-fluid">

        </div>
        <div class="col-md-6">
            <?php if ($esVoluntario) : ?>
                <p>Ya eres voluntario. ¡Gracias por tu compromiso!</p>
            <?php else : ?>
                <div class=" mt-5">
                    <h3 class="mb-4">Rellena este formulario para ser voluntario</h3>

                    <form method="post" action="voluntarios.php">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $datosUsuario['nombre']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="apellidos">Apellidos:</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $datosUsuario['apellidos']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="dni">DNI:</label>
                                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $datosUsuario['dni']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="telefono">Teléfono:</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $datosUsuario['telefono']; ?>" readonly>
                                </div>

                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $datosUsuario['email']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="cp">Código Postal:</label>
                                    <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $datosUsuario['cp']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="area_de_interes">Área de Interés:</label>
                                    <select class="form-select" id="area_de_interes" name="area_de_interes" required>
                                        <option value="cuidado_animales">Cuidado de animales</option>
                                        <option value="eventos_recaudacion">Eventos y recaudación de fondos</option>
                                        <option value="educacion_concienciacion">Educación y concienciación</option>
                                        <option value="asistencia_administrativa">Asistencia administrativa</option>
                                        <option value="apoyo_refugios">Apoyo a refugios o albergues</option>
                                        <option value="transporte_animales">Transporte de animales</option>
                                        <option value="apoyo_tecnologico">Apoyo tecnológico</option>
                                        <option value="diseno_grafico">Diseño gráfico y medios visuales</option>
                                        <option value="voluntariado_virtual">Voluntariado virtual</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="disponibilidad">Disponibilidad:</label>
                                    <select class="form-select" id="disponibilidad" name="disponibilidad" required>
                                        <option value="dias_especificos">Días específicos</option>
                                        <option value="por_horas">Por horas específicas</option>
                                        <option value="flexibilidad_horaria">Flexibilidad horaria</option>
                                        <option value="fines_de_semana">Fines de semana</option>
                                        <option value="medio_tiempo">Medio tiempo</option>
                                        <option value="tiempo_completo">Tiempo completo</option>
                                    </select>
                                </div>

                                <!-- Input hidden para el id_usuario -->
                                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" name="hacermeVoluntario">Hacerme Voluntario</button>
                    </form>
                </div>
            <?php endif; ?>

        </div>
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