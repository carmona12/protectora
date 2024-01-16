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
$stmtUsuario = $conn->prepare("SELECT * FROM usuarios WHERE id = :userId");
$stmtUsuario->bindParam(':userId', $userId);
$stmtUsuario->execute();
$usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario es socio o no
$esSocio = false;
$stmtInfoSocio = $conn->prepare("SELECT * FROM socios WHERE id_usuario = :userId");
$stmtInfoSocio->bindParam(':userId', $userId);
$stmtInfoSocio->execute();
$infoSocio = $stmtInfoSocio->fetch(PDO::FETCH_ASSOC);
$esSocio = ($infoSocio !== false);

// Verificar si el usuario es voluntario o no
$esVoluntario = false;
$stmtInfoVoluntario = $conn->prepare("SELECT * FROM voluntarios WHERE id_usuario = :userId");
$stmtInfoVoluntario->bindParam(':userId', $userId);
$stmtInfoVoluntario->execute();
$infoVoluntario = $stmtInfoVoluntario->fetch(PDO::FETCH_ASSOC);
$esVoluntario = ($infoVoluntario !== false);

//Comprobar si el usuario ha adoptado algún animal
$tieneAdoptado = false;
$stmtAdopcion = $conn->prepare("SELECT * FROM usuarios 
                                INNER JOIN adoptante ON usuarios.id = adoptante.id_usuario 
                                INNER JOIN  adopciones ON adoptante.id = adopciones.id_adoptante
                                INNER JOIN animal ON adopciones.id_animal =  animal.id
                                WHERE usuarios.id = :userId");
$stmtAdopcion->bindParam(':userId', $userId);
$stmtAdopcion->execute();
$adopciones = $stmtAdopcion->fetchAll(PDO::FETCH_ASSOC);
$tieneAdoptado = ($adopciones !== false);

// Obtener donativos del usuario
$tieneDonativos = false;
$stmtDonativos = $conn->prepare("SELECT * FROM donativos WHERE id_usuario = :userId");
$stmtDonativos->bindParam(':userId', $userId);
$stmtDonativos->execute();
$donativos = $stmtDonativos->fetchAll(PDO::FETCH_ASSOC);
$tieneDonativos = ($donativos !== false);

// Manejar la eliminación de socio
if (isset($_POST['btnConfirmar'])) {
    $stmtEliminarSocio = $conn->prepare("DELETE FROM socios WHERE id_usuario = :userId");
    $stmtEliminarSocio->bindParam(':userId', $userId);

    if ($stmtEliminarSocio->execute()) {
        header("Location: perfil_usuario.php");
        exit();
    } else {
        echo "Error al dejar de ser socio.";
    }
}

// Manejar la eliminación de voluntario
if (isset($_POST['dejar_voluntario'])) {
    $stmtEliminarVoluntario = $conn->prepare("DELETE FROM voluntarios WHERE id_usuario = :userId");
    $stmtEliminarVoluntario->bindParam(':userId', $userId);

    if ($stmtEliminarVoluntario->execute()) {
        header("Location: perfil_usuario.php");
        exit();
    } else {
        echo "Error al dejar de ser voluntario.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página perfil usuario</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <a href="../index.php" class="btn btn-secondary mb-3">Volver Atrás</a>
        <h1 class="text-center mb-4">Bienvenido a tu perfil <?php echo $usuario['usuario']; ?></h1>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="usuario-tab" data-bs-toggle="tab" data-bs-target="#perfil-usuario" type="button" role="tab" aria-controls="perfil-usuario" aria-selected="true">Usuario</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="socio-tab" data-bs-toggle="tab" data-bs-target="#perfil-socio" type="button" role="tab" aria-controls="perfil-socio" aria-selected="false">Socio</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="voluntario-tab" data-bs-toggle="tab" data-bs-target="#perfil-voluntario" type="button" role="tab" aria-controls="perfil-voluntario" aria-selected="false">Voluntario</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="adopcion-tab" data-bs-toggle="tab" data-bs-target="#perfil-adopcion" type="button" role="tab" aria-controls="perfil-adopcion" aria-selected="false">Adopciones</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="donativos-tab" data-bs-toggle="tab" data-bs-target="#perfil-donaciones" type="button" role="tab" aria-controls="perfil-donaciones" aria-selected="false">Donativos</button>
            </li>
        </ul>

        <!------- Pestaña para la información de usuario ------->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="perfil-usuario" role="tabpanel" aria-labelledby="usuario-tab" tabindex="0">
                <div class="container mt-5">
                    <form action="" method="post">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $usuario['dni']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $usuario['password']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="cp" class="form-label">CP</label>
                                <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $usuario['cp']; ?>" readonly>
                            </div>
                        </div>
                        <a href="modificar_datos_usuario.php" class="btn btn-primary mb-3">Modificar mis datos</a>

                    </form>
                </div>
            </div>

            <!-------------------------- Pestaña para la información de socio --------------------------->
            <div class="tab-pane fade" id="perfil-socio" role="tabpanel" aria-labelledby="socio-tab" tabindex="0">
                <div class="mt-3">
                    <?php if ($esSocio) : ?>
                        <form method="post" action="">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="membresia" class="form-label">Membresía</label>
                                    <input type="text" class="form-control" id="membresia" name="membresia" value="<?php echo $infoSocio['membresia']; ?>" readonly>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="importe_socio" class="form-label">Importe</label>
                                    <input type="text" class="form-control" id="importe_socio" name="importe_socio" value="<?php echo $infoSocio['importe']; ?>" readonly>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="fecha_ingreso_socio" class="form-label">Fecha de Ingreso</label>
                                    <input type="text" class="form-control" id="fecha_ingreso_socio" name="fecha_ingreso_socio" value="<?php echo $infoSocio['fecha_ingreso']; ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="iban" class="form-label">IBAN</label>
                                <input type="text" class="form-control" id="iban" name="iban" value="<?php echo $infoSocio['iban']; ?>" readonly>
                            </div>
                            <a href="modificar_datos_socio.php" class="btn btn-primary mb-3">Modificar mis datos</a>
                            <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#confirmarModal">Dejar de ser socio</button>
                        </form>

                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="confirmarModal" tabindex="-1" aria-labelledby="confirmarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmarModalLabel">Confirmación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas dejar de ser socio? Esta acción no se puede deshacer.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="btnConfirmar" id="btnConfirmar">Sí, dejar de ser socio</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="text-center">
                            <h3>¿Todavía no eres socio?</h3>
                            <a href="../socios.php" class="btn btn-primary mt-3">Click aquí para serlo</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!--------------------- Pestaña para la información de voluntario -------------------------->
            <div class="tab-pane fade" id="perfil-voluntario" role="tabpanel" aria-labelledby="voluntario-tab" tabindex="0">
                <div class="mt-3">
                    <?php if ($esVoluntario) : ?>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="area_de_interes" class="form-label">Área de interes</label>
                                <input type="text" class="form-control" id="area_de_interes" name="area_de_interes" value="<?php echo $infoVoluntario['area_de_interes']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="importe_voluntario" class="form-label">Disponibilidad</label>
                                <input type="text" class="form-control" id="importe_voluntario" name="importe_voluntario" value="<?php echo $infoVoluntario['disponibilidad']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="fecha_ingreso_voluntario" class="form-label">Fecha de Ingreso</label>
                                <input type="text" class="form-control" id="fecha_ingreso_voluntario" name="fecha_ingreso_voluntario" value="<?php echo $infoVoluntario['fecha_ingreso']; ?>" readonly>
                            </div>
                        </div>
                        <a href="modificar_datos_voluntario.php" class="btn btn-primary mb-3">Modificar mis datos</a>
                        <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#confirmarModal">Dejar de ser voluntario</button>

                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="confirmarModal" tabindex="-1" aria-labelledby="confirmarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmarModalLabel">Confirmación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas dejar de ser voluntario? Esta acción no se puede deshacer.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="dejar_voluntario" id="dejar_voluntario">Sí, dejar de ser voluntario</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="text-center">
                            <h3>¿Todavía no eres voluntario?</h3>
                            <a href="../voluntarios.php" class="btn btn-primary mt-3">Click aquí para serlo</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <!------------------- Pestaña para la información de adopciones ------------------------------>
            <div class="tab-pane fade" id="perfil-adopcion" role="tabpanel" aria-labelledby="adopcion-tab" tabindex="0">
                <?php if (!empty($adopciones)) : ?>
                    <?php foreach ($adopciones as $adopcion) : ?>
                        <div class=" d-flex mt-3 ">
                            <div class="rounded" style="width: 170px; height: 170px; overflow: hidden;">
                                <img src="../<?php echo $adopcion['foto_animal']; ?>" alt="Foto del animal" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="ms-3">
                                <p><strong>Nombre:</strong> <?php echo $adopcion['nombre']; ?></p>
                                <p><strong>Raza:</strong> <?php echo $adopcion['raza']; ?></p>
                                <p><strong>Edad:</strong> <?php echo $adopcion['edad']; ?> años</p>
                                <p><strong>Sexo:</strong> <?php echo $adopcion['sexo']; ?></p>
                                <p><strong>Fecha de Adopción:</strong> <?php echo $adopcion['fecha_adopcion']; ?></p>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="text-center">
                        <h3>¿Todavía no has adoptado?</h3>
                        <a href="../adoptar.php" class="btn btn-primary mt-3">Click aquí para adoptar</a>
                    </div>
                <?php endif; ?>
            </div>
            <!------------------- Pestaña para la información de donativos ------------------------------>
            <div class="tab-pane fade" id="perfil-donaciones" role="tabpanel" aria-labelledby="donativos-tab" tabindex="0">
                <?php if (!empty($tieneDonativos)) : ?>
                    <?php foreach ($donativos as $donativo) : ?>
                        <div class="container mt-3">
                            <p><strong>Fecha de donativo:</strong> <?php echo $donativo['fecha']; ?></p>
                            <p><strong>Tipo:</strong> <?php echo $donativo['tipo']; ?></p>
                            <p><strong>Cantidad:</strong> <?php echo $donativo['cantidad']; ?></p>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="text-center">
                        <h3>¿Todavía no has adoptado?</h3>
                        <a href="../adoptar.php" class="btn btn-primary mt-3">Click aquí para adoptar</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>


    </div>


</body>

</html>