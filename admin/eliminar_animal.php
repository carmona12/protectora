<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

$animalId = isset($_GET['id']) ? $_GET['id'] : null;

if ($animalId) {
    $stmtEliminarAnimal = $conn->prepare("DELETE FROM animal WHERE id = :animal_id");
    $stmtEliminarAnimal->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
    $stmtEliminarAnimal->execute();
}

header("Location: gestionAnimales.php");
exit();
