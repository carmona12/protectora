<?php
include_once "Conexion.php";
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
  }

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $especieId = $_GET['id'];

    // Consulta para obtener las distintas raza de la especie seleccionada
    $sqlRazaAnimal = "SELECT DISTINCT raza FROM animal WHERE id_especie = :especieId";
    $stmtRazaAnimal = $conn->prepare($sqlRazaAnimal);
    $stmtRazaAnimal->bindParam(':especieId', $especieId);
    $stmtRazaAnimal->execute();
    $razas = $stmtRazaAnimal->fetchAll(PDO::FETCH_COLUMN);

    // Consulta para obtener los distintos tamaños de la especie selecionada
    $sqlTamañoAnimal = "SELECT DISTINCT tamano FROM animal WHERE id_especie = :especieId";
    $stmtTamañoAnimal = $conn->prepare($sqlTamañoAnimal);
    $stmtTamañoAnimal->bindParam(':especieId', $especieId);
    $stmtTamañoAnimal->execute();
    $tamaños = $stmtTamañoAnimal->fetchAll(PDO::FETCH_COLUMN);

    // Consulta para obtener todos los animales de la especie seleccionada
    $sqlAnimales = "SELECT * FROM animal WHERE id_especie = :especieId";

    if (isset($_GET['raza']) && !empty($_GET['raza'])) {
        $sqlAnimales .= " AND raza = :raza";
    }

    if (isset($_GET['tamano']) && !empty($_GET['tamano'])) {
        $sqlAnimales .= " AND tamano = :tamano";
    }

    if (isset($_GET['edad']) && !empty($_GET['edad'])) {
        $sqlAnimales .= " AND edad = :edad";
    }

    if (isset($_GET['sexo']) && !empty($_GET['sexo'])) {
        $sqlAnimales .= " AND sexo = :sexo";
    }

    $stmtAnimales = $conn->prepare($sqlAnimales);
    $stmtAnimales->bindParam(':especieId', $especieId);

    if (isset($_GET['raza']) && !empty($_GET['raza'])) {
        $stmtAnimales->bindParam(':raza', $_GET['raza']);
    }

    if (isset($_GET['tamano']) && !empty($_GET['tamano'])) {
        $stmtAnimales->bindParam(':tamano', $_GET['tamano']);
    }

    if (isset($_GET['edad']) && is_numeric($_GET['edad'])) {
        $stmtAnimales->bindParam(':edad', $_GET['edad']);
    }

    if (isset($_GET['sexo']) && !empty($_GET['sexo'])) {
        $stmtAnimales->bindParam(':sexo', $_GET['sexo']);
    }

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
    <title>Página Animales</title>
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
                            type: 'GET',
                            data: {
                                id_animal: idAnimal
                            },
                            success: function(response) {
                                // alert(response); // Puedes mostrar un mensaje al usuario, por ejemplo, "Adopción exitosa"
                                window.location.href = './procesar_adopcion.php?id_animal=' + idAnimal;
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
                            <a class="nav-link" aria-current="page" href="./index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./sobreNosotros.php">Sobre nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./adoptar.php">Adoptar</a>
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
    <section class="container mt-4">
        <h1 class="text-center text-warning fw-bold mb-3">Filtrar Animales</h1>
        <form action="animales.php" method="get">
            <input type="hidden" name="id" value="<?= $especieId ?>">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="raza">Raza:</label>
                    <select class="form-select" id="raza" name="raza">
                        <option value="">Todas las razas</option>
                        <?php foreach ($razas as $raza) : ?>
                            <option value="<?= $raza ?>"> <?= $raza ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tamano">Tamaño:</label>
                    <select class="form-select" id="tamano" name="tamano">
                        <option value="">Todos los tamaños</option>
                        <?php foreach ($tamaños as $tamano) : ?>
                            <option value="<?= $tamano ?>"> <?= $tamano ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="edad">Edad:</label>
                    <input type="number" class="form-control" id="edad" name="edad" placeholder="Edad">
                </div>
                <div class="col-md-3">
                    <label for="sexo">Sexo:</label>
                    <select class="form-select" id="sexo" name="sexo">
                        <option value="">Todos los sexos</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
        <h1 class="text-center text-warning fw-bold mb-3">Animales de la especie seleccionada</h1>
        <div class="row">
            <?php
            $stmtAnimalesAdoptados = $conn->prepare("SELECT id_animal FROM adopciones");
            $stmtAnimalesAdoptados->execute();
            $animalesAdoptados = $stmtAnimalesAdoptados->fetchAll(PDO::FETCH_COLUMN);

            // Mostrar los animales de la especie seleccionada
            if (!empty($animales)) {
                foreach ($animales as $animal) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card" style="width: auto;">';
                    echo '<img src="' . $animal["foto_animal"] . '" class="card-img-top" alt="Imagen del animal">';
                    echo '<div class="card-body text-center">';
                    echo '<h5 class="card-title">' . $animal["nombre"] . '</h5>';
                    echo '<p class="card-text">' . $animal["informacion"] . '</p>';
                    // Verificar si el ID del animal está en la lista de animales adoptados
                    $disabled = in_array($animal['id'], $animalesAdoptados) ? 'disabled' : '';
                    echo '<button class="btn btn-primary" onclick="adoptarAnimal(' . $animal["id"] . ')" ' . $disabled . '>Adoptar</button>';
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