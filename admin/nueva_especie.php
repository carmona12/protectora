<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

    $nombre_especie = $_POST['nombre_especie'];
    $foto_especie = $_POST['foto_especie'];

    // Asegúrate de validar y limpiar los datos antes de insertarlos en la base de datos

    // Insertar nueva especie en la base de datos
    $stmtNuevaEspecie = $conn->prepare("INSERT INTO especies (especie, foto_especie) VALUES (?, ?)");
    $stmtNuevaEspecie->execute([$nombre_especie, $foto_especie]);

    // Redirigir a la página de lista de especies después de agregar una nueva especie
    header("Location: especies.php");
    exit();

?>