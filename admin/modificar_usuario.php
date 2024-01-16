<?php
include_once "../Conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../usuario/login.php");
    exit();
}

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Obtener datos del usuario
    $stmtUsuario = $conn->prepare("SELECT * FROM usuarios WHERE id = :userId");
    $stmtUsuario->bindParam(':userId', $userId);
    $stmtUsuario->execute();
    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("Location: gestionUsuarios.php");
        exit();
    }
} else {
    header("Location: gestionUsuarios.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se proporciona una nueva contraseña
    if (!empty($_POST['new_password'])) {
        $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        // Actualizar los datos en la base de datos incluyendo la nueva contraseña
        $stmtModificarUsuario = $conn->prepare("UPDATE usuarios SET usuario = :usuario, password = :newPassword, nombre = :nombre, apellidos = :apellidos, dni = :dni, email = :email, telefono = :telefono, cp = :cp, rol = :rol WHERE id = :userId");
        $stmtModificarUsuario->bindParam(':newPassword', $newPassword);
    } else {
        // Actualizar los datos en la base de datos sin cambiar la contraseña
        $stmtModificarUsuario = $conn->prepare("UPDATE usuarios SET usuario = :usuario, nombre = :nombre, apellidos = :apellidos, dni = :dni, email = :email, telefono = :telefono, cp = :cp, rol = :rol WHERE id = :userId");
    }

    $stmtModificarUsuario->bindParam(':usuario', $_POST['usuario']);
    $stmtModificarUsuario->bindParam(':nombre', $_POST['nombre']);
    $stmtModificarUsuario->bindParam(':apellidos', $_POST['apellidos']);
    $stmtModificarUsuario->bindParam(':dni', $_POST['dni']);
    $stmtModificarUsuario->bindParam(':email', $_POST['email']);
    $stmtModificarUsuario->bindParam(':telefono', $_POST['telefono']);
    $stmtModificarUsuario->bindParam(':cp', $_POST['cp']);
    $stmtModificarUsuario->bindParam(':rol', $_POST['rol']);
    $stmtModificarUsuario->bindParam(':userId', $userId);
    if ($stmtModificarUsuario->execute()) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Modificar Usuario</h1>

        <form action="" method="post">

            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $usuario['dni']; ?>" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        <button type="button" class="btn btn-outline-secondary" onclick="toggleNewPassword()">Mostrar</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="cp" class="form-label">CP</label>
                    <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $usuario['cp']; ?>" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="admin" <?php echo ($usuario['rol'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="usuario" <?php echo ($usuario['rol'] === 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Guardar Cambios</button>
            <a href="gestionUsuarios.php" class="btn btn-secondary mb-3">Volver Atrás</a>
        </form>
    </div>
</body>
<script>
    function toggleNewPassword() {
        var newPasswordInput = document.getElementById('new_password');
        if (newPasswordInput.type === 'password') {
            newPasswordInput.type = 'text';
        } else {
            newPasswordInput.type = 'password';
        }
    }
</script>

</html>