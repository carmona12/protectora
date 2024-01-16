<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}
// Obtener las especies de la base de datos
$stmtEspecies = $conn->prepare("SELECT id, especie FROM especies");
$stmtEspecies->execute();
$especies = $stmtEspecies->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $raza = $_POST['raza'];
    $tamano = $_POST['tamano'];
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $estado_salud = $_POST['estado_salud'];
    $informacion = $_POST['informacion'];
    $id_especie = $_POST['id_especie'];
    $foto_animal = $_POST['foto_animal'];

    $stmtNuevoAnimal = $conn->prepare("INSERT INTO animal (nombre, raza, tamano, edad, sexo, fecha_ingreso, estado_salud, informacion, foto_animal, id_especie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtNuevoAnimal->execute([$nombre, $raza, $tamano, $edad, $sexo, $fecha_ingreso, $estado_salud, $informacion, $foto_animal, $id_especie]);

    header("Location: gestionAnimales.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Animal</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <section class="container mt-4 contenido-principal">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Añadir Nuevo Animal</h2>
                        <form action="" method="post">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚ\s]+" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="raza" class="form-label">Raza:</label>
                                    <input type="text" class="form-control" id="raza" name="raza" pattern="[a-zA-ZáéíóúÁÉÍÓÚ\s\/]+" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tamano" class="form-label">Tamaño:</label>
                                    <select class="form-select" id="tamano" name="tamano" required>
                                        <option value="" selected disabled>Selecciona un tamaño</option>
                                        <option value="Pequeño">Pequeño</option>
                                        <option value="Medio">Medio</option>
                                        <option value="Grande">Grande</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="edad" class="form-label">Edad:</label>
                                    <input type="number" class="form-control" id="edad" name="edad" min="0" placeholder="0" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="sexo" class="form-label">Sexo:</label>
                                    <select class="form-select" id="sexo" name="sexo" required>
                                        <option value="" selected disabled>Selecciona el sexo</option>
                                        <option value="Macho">Macho</option>
                                        <option value="Hembra">Hembra</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estado_salud" class="form-label">Estado de Salud:</label>
                                <input type="text" class="form-control" id="estado_salud" name="estado_salud" pattern="[a-zA-ZáéíóúÁÉÍÓÚ\s\.,;'-]+" required>
                            </div>

                            <div class="mb-3">
                                <label for="informacion" class="form-label">Información Adicional:</label>
                                <textarea class="form-control" id="informacion" name="informacion" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="foto_animal">Foto animal</label>
                                <input type="text" class="form-control" name="foto_animal" id="foto_animal" required>
                            </div>

                            <div class="mb-3">
                                <label for="id_especie" class="form-label">ID Especie:</label>
                                <select class="form-select" id="id_especie" name="id_especie" required>
                                    <option value="" selected disabled>Selecciona una especie</option>
                                    <?php foreach ($especies as $especie) : ?>
                                        <option value="<?php echo $especie['id']; ?>"><?php echo $especie['especie']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary">Guardar Animal</button>
                                <a href="gestionAnimales.php" class="btn btn-secondary">Volver atrás</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>