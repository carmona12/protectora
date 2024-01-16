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
    <title>Página Colabora</title>
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
                            <a class="nav-link " aria-current="page" href="./index.php">Inicio</a>
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
                            <li class="nav-item">
                                <a class="nav-link" href="usuario/login.php"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5 mb-4">
        <div class="row row-cols-1 row-cols-md-3 g-4 align-items-stretch">
            <div class="col-md-4 mb-4">
                <div class="text-center h-100">
                    <h4>Únete como Socio: Construyamos Esperanza Animal Juntos</h4>
                    <img src="./imagenes/colabora/hazteSocio.png" alt="Hazte Socio" class="rounded-circle img-fluid mb-3">
                    <p class="lead">Sé parte de nuestra comunidad como socio y apoya a los animales necesitados. Contribuye financieramente, participa en eventos exclusivos y forma parte de una red dedicada al bienestar animal. Tu ayuda construye puentes hacia un futuro más compasivo. ¡Hazte socio y sé el cambio!</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo empty($usuario) ? 'usuario/login.php' : 'socios.php'; ?>" class="btn btn-primary">Hacerme Socio</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="text-center h-100">
                    <h4>Únete a Nosotros: Sé Voluntario en Esperanza Animal</h4>
                    <img src="./imagenes/colabora/hazteVoluntario.jpg" alt="Hazte Voluntario" class="rounded-circle img-fluid mb-3">
                    <p class="lead">Haz una diferencia tangible en la vida de los animales siendo voluntario en nuestra protectora. Participa en eventos, cuida a nuestros amigos peludos, y comparte el amor por los animales. Tu tiempo cuenta y puede cambiar vidas. ¡Haz clic para ser voluntario y forma parte de nuestro compromiso con el bienestar animal!</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo empty($usuario) ? 'usuario/login.php' : 'voluntarios.php'; ?>" class="btn btn-primary">Hacerme Voluntario</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="text-center h-100">
                    <h4>Apoya con Donativos: Construyamos Juntos el Bienestar Animal</h4>
                    <img src="./imagenes/colabora/donativos2.jpg" alt="Donativo" class="rounded-circle img-fluid mb-3">
                    <p class="lead">Contribuye a nuestra causa donando y forma parte del cambio positivo en la vida de los animales necesitados. Cada donativo, sin importar el tamaño, construye un futuro más esperanzador. Tu generosidad es clave para brindar amor y cuidado a nuestros amigos peludos. ¡Haz clic para donar hoy y sé parte de nuestro compromiso con el bienestar animal! Tu contribución hace la diferencia.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo empty($usuario) ? 'usuario/login.php' : 'donativos.php'; ?>" class="btn btn-primary">Donar</a>
                    </div>
                </div>
            </div>
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