<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

$especieId = isset($_GET['id']) ? $_GET['id'] : null;

// Comprobar si se encontró la especie
if ($especieId) {
    $stmtEliminarEspecie = $conn->prepare("DELETE FROM especies WHERE id = :especie_id");
    $stmtEliminarEspecie->bindParam(':especie_id', $especieId, PDO::PARAM_INT);
    $stmtEliminarEspecie->execute();
}

header("Location: especies.php");
exit();
?>

