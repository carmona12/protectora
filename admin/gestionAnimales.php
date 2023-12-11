<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}

if (isset($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
    if (empty($busqueda)) {
        $mensaje = "Por favor, introduce un nombre para realizar la búsqueda.";
    } else {
        $stmtListarAnimales = $conn->prepare("SELECT * FROM animal WHERE nombre LIKE :busqueda");
        $stmtListarAnimales->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        $stmtListarAnimales->execute();
        // Obtener los resultados de la consulta
        $resultados = $stmtListarAnimales->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    // Si no se envió una búsqueda, obtener todos los animales
    $stmtListarAnimales = $conn->prepare("SELECT * FROM animal");
    $stmtListarAnimales->execute();
    // Obtener los resultados de la consulta
    $resultados = $stmtListarAnimales->fetchAll(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Gestión De Animales</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php"><img src="../imagenes/logo.png" width="50px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./gestionAnimales.php">Gestión de Animales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionSocios.php">Gestión Socios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionVoluntarios.php">Gestión Voluntarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionDonativos.php">Gestión Donativos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionUsuario.php">Gestión Usuarios</a>
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
                                    <a class="dropdown-item" href="../usuario/logout.php">Cerrar Sesión</a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="container mt-4 contenido-principal">
        <div>
            <a href="especies.php" class="btn btn-secondary btn-sm">Especies</a>
            <a href="nuevo_animal.php" class="btn btn-primary btn-sm">Nuevo Animal</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Listado de Animales</h2>
                <form class="mb-3" action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Buscar por nombre">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
                <?php
                if (isset($mensaje)) {
                    echo "<p>$mensaje</p>";
                } elseif (empty($resultados)) {
                    echo "<p>No se encontraron resultados para la búsqueda.</p>";
                } else {
                ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $animal) : ?>
                                    <tr>
                                        <td><?php echo $animal['id']; ?></td>
                                        <td>
                                            <a class="text-decoration-none fw-bold " href="?animal_id=<?php echo $animal['id']; ?>">
                                                <?php echo $animal['nombre']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="modificar_animal.php?id=<?php echo $animal['id']; ?>" class="btn btn-warning btn-sm">Modificar</a>

                                            <a href="eliminar_animal.php?id=<?php echo $animal['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este animal?')">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <form action="" method="get" class="my-3">
                    <button type="submit" class="btn btn-secondary">Mostrar Todos</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="detalle-animal">
                    <?php
                    if (isset($_GET['animal_id'])) {
                        // Lógica para obtener y mostrar detalles del animal
                        $animalId = $_GET['animal_id'];
                        $stmtDetalleAnimal = $conn->prepare("SELECT * FROM animal WHERE id = :animal_id");
                        $stmtDetalleAnimal->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
                        $stmtDetalleAnimal->execute();
                        $detalleAnimal = $stmtDetalleAnimal->fetch(PDO::FETCH_ASSOC);

                        // Mostrar detalles del animal
                        if ($detalleAnimal) {
                            echo "<h2>Detalles del Animal</h2>";
                            echo "<ul>";
                            echo "<li><strong>ID:</strong> " . $detalleAnimal['id'] . "</li>";
                            echo "<li><strong>Nombre:</strong> " . $detalleAnimal['nombre'] . "</li>";
                            echo "<li><strong>Raza:</strong> " . $detalleAnimal['raza'] . "</li>";
                            echo "<li><strong>Tamaño:</strong> " . $detalleAnimal['tamano'] . "</li>";
                            echo "<li><strong>Edad:</strong> " . $detalleAnimal['edad'] . "</li>";
                            echo "<li><strong>Sexo:</strong> " . $detalleAnimal['sexo'] . "</li>";
                            echo "<li><strong>Fecha de ingreso:</strong> " . $detalleAnimal['fecha_ingreso'] . "</li>";
                            echo "<li><strong>Estado:</strong> " . $detalleAnimal['estado_salud'] . "</li>";
                            echo "<li><strong>Información:</strong> " . $detalleAnimal['informacion'] . "</li>";
                            echo "<li><strong>Id_especie:</strong> " . $detalleAnimal['id_especie'] . "</li>";
                            echo "</ul>";

                            // Mostrar la foto del animal en un círculo
                            echo '<div class="mb-3"; style="width: 170px; height: 170px; border-radius: 50%; overflow: hidden; margin-top: 10px;">';
                            echo '<img src="../' . $detalleAnimal['foto_animal'] . '" alt="' . $detalleAnimal['nombre'] . '" style="width: 100%; height: 100%; object-fit: cover;">';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!------------------------------ FOOTER -------------------------------->
    <footer class="text-center text-white fixed-bottom" style="background-color: #6db1bf;">             
        <!-- Copyright -->
        <div class="text-center p-3" id="footerPart2">
            © 2023 Copyright: Esperanza Animal
        </div>
    </footer>



</body>

</html>