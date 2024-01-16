<?php
include_once "../Conexion.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: gestionDonativos.php");
    exit();
}

$idDonativo = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $conn->prepare("DELETE FROM donativos WHERE id = :id");
        $stmt->bindParam(":id", $idDonativo, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: gestionDonativos.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar el donativo: " . $e->getMessage();
    }
}

$stmt = $conn->prepare("SELECT * FROM donativos WHERE id = :id");
$stmt->bindParam(":id", $idDonativo, PDO::PARAM_INT);
$stmt->execute();
$donativo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donativo) {
    header("Location: gestionDonativos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Donativo</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Eliminar Donativo</h1>
        <div class="alert alert-warning" role="alert">
            ¿Está seguro de que desea eliminar el donativo con ID <?php echo $donativo['id']; ?>?
        </div>
        <form method="post" action="">
            <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
            <a href="gestionDonativos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
