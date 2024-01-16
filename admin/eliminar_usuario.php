<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

// Verificar si se proporciona un ID de usuario válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Obtener detalles del usuario para mostrar información antes de confirmar la eliminación
    $stmtObtenerUsuario = $conn->prepare("SELECT * FROM usuarios WHERE id = :idUsuario");
    $stmtObtenerUsuario->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtObtenerUsuario->execute();
    $usuario = $stmtObtenerUsuario->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        // Redirigir a la página de gestión de usuarios si no se encuentra el usuario
        header("Location: gestionUsuarios.php");
        exit();
    }
} else {
    // Redirigir a la página de gestión de usuarios si no se proporciona un ID válido
    header("Location: gestionUsuarios.php");
    exit();
}

// Verificar si se ha enviado una solicitud POST para confirmar la eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmtEliminarUsuario = $conn->prepare("DELETE FROM usuarios WHERE id = :idUsuario");
    $stmtEliminarUsuario->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

    if ($stmtEliminarUsuario->execute()) {
        // Redirigir a la página de gestión de usuarios con un mensaje de éxito
        header("Location: gestionUsuarios.php?exito=eliminacion");
        exit();
    } else {
        // Redirigir a la página de gestión de usuarios con un mensaje de error
        header("Location: gestionUsuarios.php?error=eliminacion_fallo");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Eliminar Usuario</h1>
        <div class="alert alert-warning" role="alert">
            ¿Está seguro de que desea eliminar al usuario con ID <?php echo $usuario['id']; ?>?
        </div>
        <form method="post" action="">
            <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
            <a href="gestionUsuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
