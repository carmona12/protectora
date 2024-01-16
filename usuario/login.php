<?php
include_once "../Conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        $stmtUsuario = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmtUsuario->execute(array(':usuario' => $usuario));
        $row = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Verificar si la contraseña propocionada es correcta
            if (password_verify($password, $row['password'])) {
                $_SESSION['id_usuario'] = $row['id'];
                $_SESSION['rol'] = $row['rol'];
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['password'] = $row['password'];

                if ($_SESSION['rol'] == 'admin') {
                    header("Location: ../admin/admin.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                $errorContraseña = 'La contraseña proporcionada es incorrecta.';
            }
        } else {
                $errorUsuario = 'El nombre de usuario no existe.';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="bodyLogin">

    <section class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center" style="width: 22rem;">
            <div class="card-body">
                <div class="card-title">
                    <i class="fas fa-paw"></i>
                    <h2 class="text-primary">Bienvenid@ a nuestra Protectora</h2>
                </div>
                <form class="" action="" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="inputUsuario" placeholder="Usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="inputContraseña" placeholder="Contraseña" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="botonLogin">Iniciar Sesión</button>
                </form>
                <?php if (!empty($errorUsuario)) : ?>
                    <script>
                        Swal.fire({
                            title: '¡Usuario incorrecto!',
                            text: '<?php echo $errorUsuario; ?>',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    </script>
                <?php endif; ?>

                <?php if (!empty($errorContraseña)) : ?>
                    <script>
                        Swal.fire({
                            title: '¡Contraseña errónea!',
                            text: '<?php echo $errorContraseña; ?>',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    </script>
                <?php endif; ?>
            </div>
            <div class="card-footer text-muted">
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a> </p>
            </div>
        </div>
        <a href="../index.php" class="btn btn-secondary position-absolute top-0 start-0 mt-3 ms-3">Volver atrás</a>
    </section>
</body>

</html>