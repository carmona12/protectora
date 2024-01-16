<?php
include_once "Conexion.php";
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Sobre Nosotros</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <style>
        @media (min-width: 1370px) {
            footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        }

        #tituloAcordeon1 {
            background-color: #6db1bf;
            font-weight: bold;
        }

        #tituloAcordeon2 {
            background-color: #A09FF6;
            font-weight: bold;
        }
    </style>
</head>

<body style="background-image: url(./imagenes/acordeon/a1.jpg);">
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
                            <a class="nav-link active" href="./sobreNosotros.php">Sobre nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./adoptar.php">Adoptar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./colabora.php">Colabora</a>
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
                                    <a class="dropdown-item" href="./usuario/perfil_usuario.php">Mi Perfil</a>
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
    <!-------------------------------- Acordeón sobre nosotros -------------------------------->
    <section class="container mt-5">
        <div class="accordion accordion-flush mb-3" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" id="tituloAcordeon1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        ¿Quiénes Somos?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body" style="background-color: #A09FF6;">
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center">
                                Somos una protectora de animales dedicada al bienestar y cuidado de los animales en Guillena, Sevilla. Nuestra misión es proporcionar un hogar seguro y amoroso para aquellos animales que han sido abandonados o maltratados.
                            </div>
                            <div class="col-md-6 text-end">
                                <img src="./imagenes/acordeon/perroPelota.gif" alt="" class="img-fluid" style="max-height: 250px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" id="tituloAcordeon2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Nuestros Objetivos
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body" style="background-color: #F5F69F;">
                        <div class="row align-items-center">
                            <div class="col-md-6 text-end">
                                <img src="./imagenes/acordeon/nuestrosObjetivos.png" alt="" class="img-fluid" style="max-height: 250px;">
                            </div>
                            <div class="col-md-6 text-center">
                                Nuestro principal objetivo es promover el respeto y el amor hacia los animales, así como fomentar la adopción responsable. Trabajamos arduamente para concientizar a la comunidad sobre la importancia de cuidar a nuestros amigos peludos.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" id="tituloAcordeon1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Logros Destacados
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body" style="background-color: #A09FF6;">
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center">
                                ¡Estamos orgullosos de nuestros logros! Hemos logrado aumentar significativamente las adopciones de animales rescatados, mejorando así sus vidas y encontrando hogares amorosos. Además, hemos llevado a cabo exitosas campañas de concientización que han educado a la comunidad sobre el bienestar animal. ¡Gracias a nuestro dedicado equipo y a la generosidad de nuestros donantes por hacer todo esto posible!
                            </div>
                            <div class="col-md-6 text-end">
                                <img src="./imagenes/acordeon/nuestrosLogros.png" alt="" class="img-fluid" style="max-height: 250px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
                        <li><a href="./index.php" class="text-white text-decoration-none"><i class="fas fa-home me-3"></i> Inicio</a></li>
                        <li><a href="./sobreNosotros.php" class="text-white text-decoration-none"><i class="fas fa-info-circle me-3"></i> Sobre Nosotros</a></li>
                        <li><a href="./adoptar.php" class="text-white text-decoration-none"><i class="fas fa-paw me-3"></i> Adoptar</a></li>
                        <li><a href="./colabora.php" class="text-white text-decoration-none"><i class="fas fa-hands-helping me-3"></i> Colabora</a></li>
                        <li><a href="./contactenos.php" class="text-white text-decoration-none"><i class="fas fa-envelope me-3"></i> Contáctenos</a></li>
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