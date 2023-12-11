<?php
include_once "../Conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nuevoNombre = $_POST["nombre_especie"];
    $nuevaFoto = $_POST["foto_especie"];


    // Actualiza los datos en la base de datos
    $stmt = $conn->prepare("UPDATE especies SET especie = :nombre, foto_especie = :foto WHERE id = :id");
    $stmt->bindParam(':nombre', $nuevoNombre);
    $stmt->bindParam(':foto', $nuevaFoto);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION["mensaje"] = "Especie modificada correctamente";
    } else {
        $_SESSION["error"] = "Error al modificar la especie";
    }

    header("Location: especies.php");
    exit();
} else {
    // Si se intenta acceder directamente a modificar_especie.php sin enviar datos, redirige a la página principal
    header("Location: especies.php");
    exit();
}
