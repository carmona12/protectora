<?php
include_once "Conexion.php";
session_start();
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: usuario/login.php");
    exit();
}
// Obtener el ID del animal de la URL
$idAnimal = isset($_GET['id_animal']) ? $_GET['id_animal'] : null;
$idUsuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
var_dump($idUsuario);
var_dump($idAnimal);

if (isset($_POST['botonAdoptar'])) {

    if (isset($idUsuario) && is_numeric($idAnimal)) {
        // Verificar si el adoptante ya existe en la tabla de adoptantes
        $stmtComprobarAdoptante = $conn->prepare("SELECT COUNT(*) FROM adoptante WHERE id_usuario = :id_usuario");
        $stmtComprobarAdoptante->bindParam(':id_usuario', $idUsuario);
        $stmtComprobarAdoptante->execute();
        $adoptanteExiste = $stmtComprobarAdoptante->fetchColumn();

        // Si el adoptante no existe, puedes insertarlo en la tabla de adoptantes
        if (!$adoptanteExiste) {
            $sqlInsertarAdoptante = "INSERT INTO adoptante (id_usuario) VALUES (:id_usuario)";
            $stmtInsertarAdoptante = $conn->prepare($sqlInsertarAdoptante);
            $stmtInsertarAdoptante->bindParam(':id_usuario', $idUsuario);

            if ($stmtInsertarAdoptante->execute()) {
                echo "Adoptante creado correctamente";
            } else {
                echo "Error al crear el adoptante";
            }
        }

        $stmtComprobarAdoptante = $conn->prepare("SELECT id FROM adoptante WHERE id_usuario = :id_usuario");
        $stmtComprobarAdoptante->bindParam(':id_usuario', $idUsuario);
        $stmtComprobarAdoptante->execute();
        $idAdoptante = $stmtComprobarAdoptante->fetchColumn();

        if (!$idAdoptante) {
            // El adoptante no existe, maneja este caso según tus necesidades
            echo "Error: El adoptante no existe";
            exit();  // Terminar la ejecución del script
        }

        // Obtener la fecha actual de la adopción
        $fechaAdopcion = date("Y-m-d");

        // Insertar la adopción en la tabla de adopciones
        $sqlAdopcion = "INSERT INTO adopciones (id_adoptante, id_animal, fecha_adopcion) VALUES (:id_adoptante, :id_animal, :fecha_adopcion)";
        $stmtAdopcion = $conn->prepare($sqlAdopcion);
        $stmtAdopcion->bindParam(':id_adoptante', $idAdoptante);
        $stmtAdopcion->bindParam(':id_animal', $idAnimal);
        $stmtAdopcion->bindParam(':fecha_adopcion', $fechaAdopcion);
        $stmtAdopcion->execute();
        header("Location: index.php");
        
    } else {
        // Manejar el caso en que el usuario no está autenticado o el ID del animal no es válido
        echo "Error: El usuario no está autenticado o el ID del animal no es válido";
    }
    
       
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Adoptar</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./jquery-3.7.1.min.js"></script>
</head>
<script>

</script>

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
                            <a class="nav-link active" aria-current="page" href="./index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sobre nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./adoptar.php">Adoptar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Colabora</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contactenos.php">Contáctenos</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="usuario/login.php"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <h2>Datos del Adoptante</h2>
                <?php
                // Obtener los datos del adoptante
                $stmtObtenerDatosAdoptante = $conn->prepare("SELECT * FROM usuarios WHERE id = :id_usuario");
                $stmtObtenerDatosAdoptante->bindParam(':id_usuario', $idUsuario);
                $stmtObtenerDatosAdoptante->execute();
                $datosAdoptante = $stmtObtenerDatosAdoptante->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="" method="post" class="needs-validation" novalidate>
                    <div class="form-group mb-1">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $datosAdoptante['nombre']; ?>" readonly>
                    </div>

                    <div class="form-group mb-1">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $datosAdoptante['apellidos']; ?>" readonly>
                    </div>

                    <div class="form-group mb-1">
                        <label for="dni">DNI:</label>
                        <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $datosAdoptante['dni']; ?>" readonly>
                    </div>

                    <div class="form-group mb-1">
                        <label for="cp">Código Postal:</label>
                        <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $datosAdoptante['cp']; ?>" readonly>
                    </div>

                    <div class="form-group mb-1">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $datosAdoptante['telefono']; ?>" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label for="email">Correo Electrónico:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $datosAdoptante['email']; ?>" readonly>
                    </div>

                    <!-- Agregar campos ocultos para enviar el ID del usuario y del animal al procesar la adopción -->
                    <input type="hidden" name="id_usuario" value="<?php echo $idUsuario; ?>">
                    <input type="hidden" name="id_animal" value="<?php echo $idAnimal; ?>">

                    <button type="submit" class="btn btn-primary" name="botonAdoptar" id="botonAdoptar">Adoptar</button>
                </form>

            </div>

            <div class="col-md-8">
                <h2>Datos del Animal</h2>
                <?php
                // Obtener los datos del animal
                $stmtObtenerDatosAnimal = $conn->prepare("SELECT * FROM animal WHERE id = :id_animal");
                $stmtObtenerDatosAnimal->bindParam(':id_animal', $idAnimal);
                $stmtObtenerDatosAnimal->execute();
                $datosAnimal = $stmtObtenerDatosAnimal->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-info table-striped-columns table-hover">
                            <tbody>
                                <tr>
                                    <th>Nombre:</th>
                                    <td><?php echo $datosAnimal['nombre']; ?></td>
                                </tr>
                                <tr>
                                    <th>Raza:</th>
                                    <td><?php echo $datosAnimal['raza']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tamaño:</th>
                                    <td><?php echo $datosAnimal['tamano']; ?></td>
                                </tr>
                                <tr>
                                    <th>Edad:</th>
                                    <td><?php echo $datosAnimal['edad']; ?></td>
                                </tr>
                                <tr>
                                    <th>Sexo:</th>
                                    <td><?php echo $datosAnimal['sexo']; ?></td>
                                </tr>
                                <tr>
                                    <th>Fecha de ingreso:</th>
                                    <td><?php echo $datosAnimal['fecha_ingreso']; ?></td>
                                </tr>
                                <tr>
                                    <th>Estado de salud:</th>
                                    <td><?php echo $datosAnimal['estado_salud']; ?></td>
                                </tr>
                                <tr>
                                    <th>Información sobre <?php echo $datosAnimal['nombre']; ?>:</th>
                                    <td><?php echo $datosAnimal['informacion']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <img class="img-fluid" src="<?php echo $datosAnimal['foto_animal']; ?>" alt="">
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