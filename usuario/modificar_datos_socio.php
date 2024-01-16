<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../usuario/login.php");
    exit();
}

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $userId = $_SESSION['id_usuario'];
}

// Obtener datos del usuario
$stmtSocio = $conn->prepare("SELECT * FROM socios WHERE id_usuario = :userId");
$stmtSocio->bindParam(':userId', $userId);
$stmtSocio->execute();
$socio = $stmtSocio->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nueva_membresia = $_POST['nueva_membresia'];
    $nuevo_importe = $_POST['nuevo_importe'];
    $nuevo_iban = $_POST['nuevo_iban'];

    $stmtModificarSocio = $conn->prepare("UPDATE socios SET membresia = :nueva_membresia, importe = :nuevo_importe, iban = :nuevo_iban WHERE id_usuario = :userId");
    $stmtModificarSocio->bindParam(':nueva_membresia', $nueva_membresia);
    $stmtModificarSocio->bindParam(':nuevo_importe', $nuevo_importe);
    $stmtModificarSocio->bindParam(':nuevo_iban', $nuevo_iban);
    $stmtModificarSocio->bindParam(':userId', $userId);

    if ($stmtModificarSocio->execute()) {
        $modificacionExitosa = 'Tus datos han sido modificados correctamente!';
    } else {
        echo "Error al actualizar los datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Datos Socio</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Modificar Datos</h1>

        <form method="post" action="">
            <div class="form-group">
                <label for="membresia">Membresía:</label>
                <select class="form-select" id="membresia" name="nueva_membresia">
                    <option value="anual" <?php echo ($socio['membresia'] === 'anual') ? 'selected' : ''; ?>>Anual</option>
                    <option value="trimestral" <?php echo ($socio['membresia'] === 'trimestral') ? 'selected' : ''; ?>>Trimestral</option>
                    <option value="mensual" <?php echo ($socio['membresia'] === 'mensual') ? 'selected' : ''; ?>>Mensual</option>
                    <option value="semanal" <?php echo ($socio['membresia'] === 'semanal') ? 'selected' : ''; ?>>Semanal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="importe">Importe:</label>
                <input type="number" class="form-control" id="importe" name="nuevo_importe" min="0" value="<?php echo $socio['importe']; ?>">
            </div>

            <div class="form-group mb-3">
                <label for="iban">IBAN:</label>
                <input type="text" class="form-control" id="iban" name="nuevo_iban" pattern="^ES\d{2}\d{4}\d{4}\d{1}\d{1}\w{10}$" value="<?php echo $socio['iban']; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="perfil_usuario.php" class="btn btn-secondary">Volver Atrás</a>
        </form>

        <?php if (!empty($modificacionExitosa)) : ?>
            <script>
                Swal.fire({
                    title: '¡Datos modificados!',
                    text: '<?php echo $modificacionExitosa; ?>',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    // Redireccionar a la página de inicio de sesión
                    window.location.href = 'perfil_usuario.php';
                });
            </script>
        <?php endif; ?>
    </div>
    <script>

    </script>
</body>

</html>