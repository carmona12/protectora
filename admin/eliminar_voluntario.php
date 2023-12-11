<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

// Verificar si se proporciona un ID de socio válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idVoluntario = $_GET['id'];

    // Eliminar socio de la base de datos
    $stmtEliminarVoluntario = $conn->prepare("DELETE FROM voluntarios WHERE id_usuario = :idVoluntario");
    $stmtEliminarVoluntario->bindParam(':idVoluntario', $idVoluntario, PDO::PARAM_INT);

    if ($stmtEliminarVoluntario->execute()) {
        // Redirigir a la página de gestión de socios con un mensaje de éxito
        header("Location: gestionVoluntarios.php?exito=eliminacion");
        exit();
    } else {
        // Redirigir a la página de gestión de socios con un mensaje de error
        header("Location: gestionVoluntarios.php?error=eliminacion_fallo");
        exit();
    }
} else {
    // Redirigir a la página de gestión de socios si no se proporciona un ID válido
    header("Location: gestionVoluntarios.php");
    exit();
}