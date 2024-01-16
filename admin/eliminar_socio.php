<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idSocio = $_GET['id'];

    $stmtEliminarSocio = $conn->prepare("DELETE FROM socios WHERE id_usuario = :idSocio");
    $stmtEliminarSocio->bindParam(':idSocio', $idSocio, PDO::PARAM_INT);

    if ($stmtEliminarSocio->execute()) {
        header("Location: gestionSocios.php?exito=eliminacion");
        exit();
    } else {
        header("Location: gestionSocios.php?error=eliminacion_fallo");
        exit();
    }
} else {
    header("Location: gestionSocios.php");
    exit();
}
