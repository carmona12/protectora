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
$stmtDonativos = $conn->prepare("SELECT * FROM donativos");
$stmtDonativos->execute();
$donativos = $stmtDonativos->fetchAll(PDO::FETCH_ASSOC);

// Calcular el importe total
$importeTotal = array_sum(array_column($donativos, 'cantidad'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Gestión De Donativos</title>
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
                            <a class="nav-link" aria-current="page" href="./gestionVoluntarios.php">Gestión Voluntarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./gestionDonativos.php">Gestión Donativos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./gestionUsuarios.php">Gestión Usuarios</a>
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
        <h1 class="text-center mb-4">Gestión de Donativos</h1>
        <div class="text-end mb-3">
            <strong>Importe Total:</strong> <?php echo number_format($importeTotal, 2); ?>€
        </div>
        <?php if (empty($donativos)) : ?>
            <div class="alert alert-info" role="alert">
                No hay donativos en la base de datos.
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donativos as $donativo) : ?>
                            <tr>
                                <td><?php echo $donativo['id']; ?></td>
                                <td><?php echo $donativo['fecha']; ?></td>
                                <td><?php echo $donativo['tipo']; ?></td>
                                <td><?php echo $donativo['cantidad']; ?></td>
                                <td>
                                    <a href="eliminar_donativo.php?id=<?php echo $donativo['id']; ?>" class="btn btn-danger btn-sm mb-1">Eliminar</a>
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