<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

// Verificar si se proporciona un ID de adopción válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $adopcionId = $_GET['id'];

    // Obtener detalles de la adopción para mostrar información antes de confirmar la eliminación
    $stmtObtenerAdopcion = $conn->prepare("SELECT adopciones.id AS id_adopcion, 
                                                adopciones.fecha_adopcion, 
                                                adopciones.precio_adopcion,
                                                usuarios.id AS id_usuario, 
                                                usuarios.nombre AS nombre_usuario,  
                                                animal.nombre AS nombre_animal, 
                                                animal.raza, 
                                                animal.foto_animal 
                                        FROM usuarios 
                                        INNER JOIN adoptante ON usuarios.id = adoptante.id_usuario 
                                        INNER JOIN adopciones ON adoptante.id = adopciones.id_adoptante
                                        INNER JOIN animal ON adopciones.id_animal = animal.id
                                        WHERE adopciones.id = :adopcion_id");
    $stmtObtenerAdopcion->bindParam(':adopcion_id', $adopcionId, PDO::PARAM_INT);
    $stmtObtenerAdopcion->execute();
    $adopcion = $stmtObtenerAdopcion->fetch(PDO::FETCH_ASSOC);

    if (!$adopcion) {
        // Redirigir a la página de gestión de adopciones si no se encuentra la adopción
        header("Location: gestionAdopciones.php");
        exit();
    }
} else {
    // Redirigir a la página de gestión de adopciones si no se proporciona un ID válido
    header("Location: gestionAdopciones.php");
    exit();
}

// Verificar si se ha enviado una solicitud POST para confirmar la eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmtEliminarAdopcion = $conn->prepare("DELETE FROM adopciones WHERE id = :adopcion_id");
    $stmtEliminarAdopcion->bindParam(':adopcion_id', $adopcionId, PDO::PARAM_INT);

    if ($stmtEliminarAdopcion->execute()) {
        // Redirigir a la página de gestión de adopciones con un mensaje de éxito
        header("Location: gestionAdopciones.php?exito=eliminacion");
        exit();
    } else {
        // Redirigir a la página de gestión de adopciones con un mensaje de error
        header("Location: gestionAdopciones.php?error=eliminacion_fallo");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Adopción</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Eliminar Adopción</h1>
        <div class="alert alert-warning" role="alert">
            ¿Está seguro de que desea eliminar la adopción de <?php echo $adopcion['nombre_animal']; ?> realizada por <?php echo $adopcion['nombre_usuario']; ?> el <?php echo $adopcion['fecha_adopcion']; ?>?
        </div>
        <form method="post" action="">
            <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
            <a href="gestionAdopciones.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
