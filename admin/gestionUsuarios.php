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

// Obtener datos de todos los voluntarios
$stmtUsuarios = $conn->prepare("SELECT * FROM usuarios");
$stmtUsuarios->execute();
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Gestión De Usuarios</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        h1 {
            color: #007bff;
        }

        .table {
            background-color: #ffffff;
        }

        .table th, .table td {
            border: 1px solid #dee2e6;
        }

        .table thead th {
            background-color: #007bff;
            color: #ffffff;
        }

    </style>
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
                            <a class="nav-link" aria-current="page" href="./gestionVoluntarios.php">Gestión Voluntarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionDonativos.php">Gestión Donativos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./gestionUsuarios.php">Gestión Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionAdopciones.php">Gestión Adopciones</a>
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

        <h1 class="text-center mb-4">Gestión de Usuarios</h1>
        <?php if (empty($usuarios)) : ?>
            <div class="alert alert-info" role="alert">
                No hay usuarios en la base de datos.
            </div>
        <?php else : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>CP</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo $usuario['usuario']; ?></td>
                            <td><?php echo $usuario['password']; ?></td>
                            <td><?php echo $usuario['nombre']; ?></td>
                            <td><?php echo $usuario['apellidos']; ?></td>
                            <td><?php echo $usuario['dni']; ?></td>
                            <td><?php echo $usuario['email']; ?></td>
                            <td><?php echo $usuario['telefono']; ?></td>
                            <td><?php echo $usuario['cp']; ?></td>
                            <td><?php echo $usuario['rol']; ?></td>
                            <td>
                                <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm mb-1">Eliminar</a>
                                <a href="modificar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning btn-sm">Modificar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</body>

</html>