<?php
include_once "Conexion.php";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $especieId = $_GET['id'];

    // Consulta para obtener todos los animales de la especie seleccionada
    $sqlAnimales = "SELECT * FROM animal WHERE id_especie = :especieId";
    $stmtAnimales = $conn->prepare($sqlAnimales);
    $stmtAnimales->bindParam(':especieId', $especieId);
    $stmtAnimales->execute();
    $animales = $stmtAnimales->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Manejo de caso donde no se proporciona el parámetro id
    header("Location: index.php"); // Redirigir a la página principal si no se proporciona id
    exit();
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
    <script>
        function adoptarAnimal(idAnimal) {
            // Verificar la sesión del usuario utilizando AJAX
            $.ajax({
                url: 'usuario/verificar_sesion.php', // Reemplaza 'verificar_sesion.php' con tu script de verificación de sesión
                type: 'GET',
                success: function(response) {
                    if (response === 'autenticado') {
                        // Si el usuario está autenticado, procesar la adopción utilizando AJAX
                        $.ajax({
                            url: 'procesar_adopcion.php', // Reemplaza 'procesar_adopcion.php' con tu script de procesamiento de adopción
                            type: 'POST',
                            data: {
                                id_animal: idAnimal
                            },
                            success: function(response) {
                                alert(response); // Puedes mostrar un mensaje al usuario, por ejemplo, "Adopción exitosa"
                            }
                        });
                    } else {
                        // Si el usuario no está autenticado, redirige a la página de inicio de sesión
                        window.location.href = 'usuario/login.php'; // Reemplaza 'login.php' con tu página de inicio de sesión
                    }
                }
            });
        }
    </script>
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
    <section class="container mt-4">
        <h1 class="text-center text-warning fw-bold mb-3">Animales de la especie seleccionada</h1>
        <div class="row">
            <?php
            // Mostrar los animales de la especie seleccionada
            if (!empty($animales)) {
                foreach ($animales as $animal) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card" style="width: auto;">';
                    echo '<img src="' . $animal["foto_animal"] . '" class="card-img-top" alt="Imagen del animal">';
                    echo '<div class="card-body text-center">';
                    echo '<h5 class="card-title">' . $animal["nombre"] . '</h5>';
                    echo '<p class="card-text">' . $animal["informacion"] . '</p>';
                    echo '<button class="btn btn-primary" onclick="adoptarAnimal(' . $animal["id"] . ')">Adoptar</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-md-12">';
                echo '<p class="text-center text-danger">No hay animales de esta especie en nuestra protectora.</p>';
                echo '</div>';
            }
            ?>
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