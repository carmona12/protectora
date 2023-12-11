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

// Obtener datos de todos los socios
$stmtVoluntarios = $conn->prepare("SELECT * FROM voluntarios INNER JOIN usuarios ON voluntarios.id_usuario = usuarios.id");
$stmtVoluntarios->execute();
$voluntarios = $stmtVoluntarios->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Gestión De Voluntarios</title>
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
                            <a class="nav-link" aria-current="page" href="./gestionAnimales.php">Gestión de Animales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionSocios.php">Gestión Socios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./gestionVoluntarios.php">Gestión Voluntarios</a>
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

    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Voluntarios</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Área de interes</th>
                    <th>Disponibilidad</th>
                    <th>Fecha de Ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voluntarios as $voluntario) : ?>
                    <tr>
                        <td><?php echo $voluntario['id']; ?></td>
                        <td><?php echo $voluntario['nombre']; ?></td>
                        <td><?php echo $voluntario['apellidos']; ?></td>
                        <td><?php echo $voluntario['dni']; ?></td>
                        <td><?php echo $voluntario['area_de_interes']; ?></td>
                        <td><?php echo $voluntario['disponibilidad']; ?></td>
                        <td><?php echo $voluntario['fecha_ingreso']; ?></td>
                        <td>
                            <a href="eliminar_voluntario.php?id=<?php echo $voluntario['id']; ?>" class="btn btn-danger btn-sm mb-1">Eliminar</a>
                            <a href="modificar_voluntario.php?id=<?php echo $voluntario['id']; ?>" class="btn btn-warning btn-sm">Modificar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!------------------------------ FOOTER -------------------------------->
    <footer class="text-center text-white fixed-bottom" style="background-color: #6db1bf;">             
        <!-- Copyright -->
        <div class="text-center p-3" id="footerPart2">
            © 2023 Copyright: Esperanza Animal
        </div>
    </footer>



</body>

</html>