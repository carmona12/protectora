<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}
// Verificar si se envió un formulario de modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Procesar el formulario de modificación aquí
    $animalId = $_POST['animal_id'];
    $nuevoNombre = $_POST['nuevo_nombre'];
    $nuevoRaza = $_POST['nuevo_raza'];
    $nuevoTamaño = $_POST['nuevo_tamano'];
    $nuevoEdad = $_POST['nuevo_edad'];
    $nuevoSexo = $_POST['nuevo_sexo'];
    $nuevaFecha = $_POST['nueva_fecha'];
    $nuevoEstado = $_POST['nuevo_estado'];
    $nuevaInformacion = $_POST['nueva_informacion'];
    $nuevaFoto = $_POST['nueva_foto'];

    // Ejemplo de consulta SQL para actualizar todos los datos del animal
    $stmtModificarAnimal = $conn->prepare("UPDATE animal SET 
        nombre = :nuevo_nombre,
        raza = :nuevo_raza,
        tamano = :nuevo_tamano,
        edad = :nuevo_edad,
        sexo = :nuevo_sexo,
        fecha_ingreso = :nueva_fecha,
        estado_salud = :nuevo_estado,
        informacion = :nueva_informacion,
        foto_animal = :nueva_foto
        WHERE id = :animal_id");

    $stmtModificarAnimal->bindParam(':nuevo_nombre', $nuevoNombre, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nuevo_raza', $nuevoRaza, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nuevo_tamano', $nuevoTamaño, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nuevo_edad', $nuevoEdad, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nuevo_sexo', $nuevoSexo, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nueva_fecha', $nuevaFecha, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nuevo_estado', $nuevoEstado, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nueva_informacion', $nuevaInformacion, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':nueva_foto', $nuevaFoto, PDO::PARAM_STR);
    $stmtModificarAnimal->bindParam(':animal_id', $animalId, PDO::PARAM_INT);

    // Ejecutar la consulta de modificación
    $stmtModificarAnimal->execute();

    // Redirigir a la página de gestión después de la modificación
    header("Location: gestionAnimales.php");
    exit();
}

// Obtener el ID del animal de la URL
$animalId = isset($_GET['id']) ? $_GET['id'] : null;

// Obtener los detalles del animal
$stmtDetalleAnimal = $conn->prepare("SELECT * FROM animal WHERE id = :animal_id");
$stmtDetalleAnimal->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
$stmtDetalleAnimal->execute();
$detalleAnimal = $stmtDetalleAnimal->fetch(PDO::FETCH_ASSOC);

// Comprobar si se encontró el animal
if (!$detalleAnimal) {
    // Redirigir a la página de gestión si no se encontró el animal
    header("Location: gestionAnimales.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Animal</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-4">
        <h2>Modificar Animal</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="animal_id" value="<?php echo $detalleAnimal['id']; ?>">
            <div class="form-group">
                <label for="nuevo_nombre">Nuevo Nombre:</label>
                <input type="text" class="form-control" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $detalleAnimal['nombre']; ?>">
            </div>
            <div class="form-group">
                <label for="nuevo_raza">Nueva Raza:</label>
                <input type="text" class="form-control" id="nuevo_raza" name="nuevo_raza" value="<?php echo $detalleAnimal['raza']; ?>">
            </div>
            <div class="form-group">
                <label for="nuevo_tamano">Nuevo Tamaño:</label>
                <select class="form-select" id="nuevo_tamano" name="nuevo_tamano" required>
                    <option value="Pequeño" <?php echo ($detalleAnimal['tamano'] === 'Pequeño') ? 'selected' : ''; ?>>Pequeño</option>
                    <option value="Medio" <?php echo ($detalleAnimal['tamano'] === 'Medio') ? 'selected' : ''; ?>>Medio</option>
                    <option value="Grande" <?php echo ($detalleAnimal['tamano'] === 'Grande') ? 'selected' : ''; ?>>Grande</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nuevo_edad">Nueva Edad:</label>
                <input type="number" class="form-control" id="nuevo_edad" name="nuevo_edad" value="<?php echo $detalleAnimal['edad']; ?>">
            </div>
            <div class="form-group">
                <label for="nuevo_sexo">Nuevo Sexo:</label>
                <select class="form-select" id="nuevo_sexo" name="nuevo_sexo">
                    <option value="Macho" <?php echo ($detalleAnimal['sexo'] === 'Macho') ? 'selected' : ''; ?>>Macho</option>
                    <option value="Hembra" <?php echo ($detalleAnimal['sexo'] === 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nueva_fecha">Nueva fecha de ingreso:</label>
                <input type="date" class="form-control" name="nueva_fecha" id="nueva_fecha" value="<?php echo $detalleAnimal['fecha_ingreso']; ?>">
            </div>
            <div class="form-group">
                <label for="nuevo_estado">Nuevo Estado:</label>
                <input type="text" class="form-control" id="nuevo_estado" name="nuevo_estado" value="<?php echo $detalleAnimal['estado_salud']; ?>">
            </div>
            <div class="form-group">
                <label for="nueva_informacion">Nueva Información:</label>
                <textarea class="form-control" id="nueva_informacion" name="nueva_informacion" rows="3"><?php echo $detalleAnimal['informacion']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="nueva_foto">Nueva foto animal:</label>
                <input type="text" class="form-control" name="nueva_foto" id="nueva_foto" value="<?php echo $detalleAnimal['foto_animal']; ?>">
            </div>

            <button type="submit" class="btn btn-primary my-3">Guardar Cambios</button>
            <a href="gestionAnimales.php" class="btn btn-secondary">Volver atrás</a>
        </form>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>