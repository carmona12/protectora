<?php
include_once "../Conexion.php";
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

$socioId = isset($_GET['id']) ? $_GET['id'] : null;

// Obtener datos de membresía del usuario actual
$stmtMembresia = $conn->prepare("SELECT * FROM socios WHERE id_usuario = :id_usuario");
$stmtMembresia->bindParam(':id_usuario', $socioId, PDO::PARAM_INT);
$stmtMembresia->execute();
$datosMembresia = $stmtMembresia->fetch(PDO::FETCH_ASSOC);

// var_dump($socioId);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idSocio = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nueva_membresia = $_POST['nueva_membresia'];
        $nuevo_importe = $_POST['nuevo_importe'];
        $nueva_fecha = $_POST['nueva_fecha'];
        $nuevo_iban = $_POST['nuevo_iban'];

        try {
            $stmtModificarSocio = $conn->prepare("UPDATE socios SET membresia = :nueva_membresia, importe = :nuevo_importe, fecha_ingreso = :nueva_fecha, iban = :nuevo_iban WHERE id_usuario = :idSocio");
            $stmtModificarSocio->bindParam(':nueva_membresia', $nueva_membresia);
            $stmtModificarSocio->bindParam(':nuevo_importe', $nuevo_importe);
            $stmtModificarSocio->bindParam(':nueva_fecha', $nueva_fecha);
            $stmtModificarSocio->bindParam(':nuevo_iban', $nuevo_iban);
            $stmtModificarSocio->bindParam(':idSocio', $idSocio, PDO::PARAM_INT);

            if ($stmtModificarSocio->execute()) {
                header("Location: gestionSocios.php?exito=modificacion");
                exit();
            } else {
                header("Location: gestionSocios.php?error=modificacion_fallo");
                exit();
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }

    // Obtener los datos actuales del socio
    $stmtObtenerSocio = $conn->prepare("SELECT * FROM socios WHERE id_usuario = :idSocio");
    $stmtObtenerSocio->bindParam(':idSocio', $idSocio, PDO::PARAM_INT);
    $stmtObtenerSocio->execute();
    $datosSocio = $stmtObtenerSocio->fetch(PDO::FETCH_ASSOC);

    if (!$datosSocio) {
        header("Location: gestionSocios.php?error=socio_no_encontrado");
        exit();
    }
} else {
    header("Location: gestionSocios.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Modificar Socio</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Modificar Socio</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="membresia">Membresía:</label>
                <select class="form-select" id="membresia" name="nueva_membresia" required>
                    <option value="anual" <?php echo ($datosMembresia['membresia'] === 'anual') ? 'selected' : ''; ?>>Anual</option>
                    <option value="trimestral" <?php echo ($datosMembresia['membresia'] === 'trimestral') ? 'selected' : ''; ?>>Trimestral</option>
                    <option value="mensual" <?php echo ($datosMembresia['membresia'] === 'mensual') ? 'selected' : ''; ?>>Mensual</option>
                    <option value="semanal" <?php echo ($datosMembresia['membresia'] === 'semanal') ? 'selected' : ''; ?>>Semanal</option>
                </select>
            </div>


            <div class="form-group">
                <label for="importe">Importe:</label>
                <input type="text" class="form-control" id="importe" name="nuevo_importe" value="<?php echo $datosMembresia['importe']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nueva_fecha">Nueva fecha de ingreso:</label>
                <input type="date" class="form-control" name="nueva_fecha" id="nueva_fecha" value="<?php echo $datosMembresia['fecha_ingreso']; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="iban">IBAN:</label>
                <input type="text" class="form-control" id="iban" name="nuevo_iban" value="<?php echo $datosMembresia['iban']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="gestionSocios.php" class="btn btn-secondary">Volver Atrás</a>
        </form>
    </div>
    <!------------------------------ FOOTER -------------------------------->
    <footer class="text-center text-white fixed-bottom" style="background-color: #6db1bf;">
        <!-- Copyright -->
        <div class="text-center p-3" id="footerPart2">
            © 2023 Copyright: Esperanza Animal
        </div>
    </footer>
</body>

</html>