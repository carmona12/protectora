<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protectora-esperanza-animal";

// Crear la conexión con la base de datos
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   echo "Conexión exitosa";
   // print("Conexión exitosa");
  }catch(PDOException $e){
      echo "Error de conexión: " . $e->getMessage();
}
?> 