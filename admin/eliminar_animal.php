<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

// Verificar si se proporciona un ID de animal válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $animalId = $_GET['id'];

    // Obtener detalles del animal para mostrar información antes de confirmar la eliminación
    $stmtObtenerAnimal = $conn->prepare("SELECT * FROM animal WHERE id = :animal_id");
    $stmtObtenerAnimal->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
    $stmtObtenerAnimal->execute();
    $animal = $stmtObtenerAnimal->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        // Redirigir a la página de gestión de animales si no se encuentra el animal
        header("Location: gestionAnimales.php");
        exit();
    }
} else {
    // Redirigir a la página de gestión de animales si no se proporciona un ID válido
    header("Location: gestionAnimales.php");
    exit();
}

// Verificar si se ha enviado una solicitud POST para confirmar la eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmtEliminarAnimal = $conn->prepare("DELETE FROM animal WHERE id = :animal_id");
    $stmtEliminarAnimal->bindParam(':animal_id', $animalId, PDO::PARAM_INT);

    if ($stmtEliminarAnimal->execute()) {
        // Redirigir a la página de gestión de animales con un mensaje de éxito
        header("Location: gestionAnimales.php?exito=eliminacion");
        exit();
    } else {
        // Redirigir a la página de gestión de animales con un mensaje de error
        header("Location: gestionAnimales.php?error=eliminacion_fallo");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Animal</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Eliminar Animal</h1>
        <div class="alert alert-warning" role="alert">
            ¿Está seguro de que desea eliminar al animal con ID <?php echo $animal['id']; ?>?
        </div>
        <form method="post" action="">
            <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
            <a href="gestionAnimales.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
