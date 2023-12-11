<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}
var_dump($idSocio);
// Verificar si se proporciona un ID de socio válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idSocio = $_GET['id'];

    // Eliminar socio de la base de datos
    $stmtEliminarSocio = $conn->prepare("DELETE FROM socios WHERE id_usuario = :idSocio");
    $stmtEliminarSocio->bindParam(':idSocio', $idSocio, PDO::PARAM_INT);

    if ($stmtEliminarSocio->execute()) {
        // Redirigir a la página de gestión de socios con un mensaje de éxito
        header("Location: gestionSocios.php?exito=eliminacion");
        exit();
    } else {
        // Redirigir a la página de gestión de socios con un mensaje de error
        header("Location: gestionSocios.php?error=eliminacion_fallo");
        exit();
    }
} else {
    // Redirigir a la página de gestión de socios si no se proporciona un ID válido
    header("Location: gestionSocios.php");
    exit();
}
