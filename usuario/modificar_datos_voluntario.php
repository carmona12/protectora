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
$stmtVoluntario = $conn->prepare("SELECT * FROM voluntarios WHERE id_usuario = :userId");
$stmtVoluntario->bindParam(':userId', $userId);
$stmtVoluntario->execute();
$voluntario = $stmtVoluntario->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nueva_area_de_interes = $_POST['nueva_area_de_interes'];
    $nueva_disponibilidad = $_POST['nueva_disponibilidad'];

    $stmtModificarVoluntario = $conn->prepare("UPDATE voluntarios SET area_de_interes = :nueva_area_de_interes, disponibilidad = :nueva_disponibilidad WHERE id_usuario = :userId");
    $stmtModificarVoluntario->bindParam(':nueva_area_de_interes', $nueva_area_de_interes);
    $stmtModificarVoluntario->bindParam(':nueva_disponibilidad', $nueva_disponibilidad);
    $stmtModificarVoluntario->bindParam(':userId', $userId);

    if ($stmtModificarVoluntario->execute()) {
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
    <title>Modificar Datos Voluntario</title>
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
            <div class="form-group mb-3">
                <label for="nueva_area_de_interes">Área de Interés:</label>
                <select class="form-select" id="nueva_area_de_interes" name="nueva_area_de_interes" required>
                    <option value="cuidado_animales" <?php echo ($voluntario['area_de_interes'] === 'cuidado_animales') ? 'selected' : ''; ?>>Cuidado de animales</option>
                    <option value="eventos_recaudacion" <?php echo ($voluntario['area_de_interes'] === 'eventos_recaudacion') ? 'selected' : ''; ?>>Eventos y recaudación de fondos</option>
                    <option value="educacion_concienciacion" <?php echo ($voluntario['area_de_interes'] === 'educacion_concienciacion') ? 'selected' : ''; ?>>Educación y concienciación</option>
                    <option value="asistencia_administrativa" <?php echo ($voluntario['area_de_interes'] === 'asistencia_administrativa') ? 'selected' : ''; ?>>Asistencia administrativa</option>
                    <option value="apoyo_refugios" <?php echo ($voluntario['area_de_interes'] === 'apoyo_refugios') ? 'selected' : ''; ?>>Apoyo a refugios o albergues</option>
                    <option value="transporte_animales" <?php echo ($voluntario['area_de_interes'] === 'transporte_animales') ? 'selected' : ''; ?>>Transporte de animales</option>
                    <option value="apoyo_tecnologico" <?php echo ($voluntario['area_de_interes'] === 'apoyo_tecnologico') ? 'selected' : ''; ?>>Apoyo tecnológico</option>
                    <option value="diseno_grafico" <?php echo ($voluntario['area_de_interes'] === 'diseno_grafico') ? 'selected' : ''; ?>>Diseño gráfico y medios visuales</option>
                    <option value="voluntariado_virtual" <?php echo ($voluntario['area_de_interes'] === 'voluntariado_virtual') ? 'selected' : ''; ?>>Voluntariado virtual</option>
                    <option value="otros" <?php echo ($voluntario['area_de_interes'] === 'otros') ? 'selected' : ''; ?>>Otros</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="nueva_disponibilidad">Disponibilidad:</label>
                <select class="form-select" id="nueva_disponibilidad" name="nueva_disponibilidad" required>
                    <option value="dias_especificos" <?php echo ($voluntario['disponibilidad'] === 'dias_especificos') ? 'selected' : ''; ?>>Días específicos</option>
                    <option value="por_horas" <?php echo ($voluntario['disponibilidad'] === 'por_horas') ? 'selected' : ''; ?>>Por horas específicas</option>
                    <option value="flexibilidad_horaria" <?php echo ($voluntario['disponibilidad'] === 'flexibilidad_horaria') ? 'selected' : ''; ?>>Flexibilidad horaria</option>
                    <option value="fines_de_semana" <?php echo ($voluntario['disponibilidad'] === 'fines_de_semana') ? 'selected' : ''; ?>>Fines de semana</option>
                    <option value="medio_tiempo" <?php echo ($voluntario['disponibilidad'] === 'medio_tiempo') ? 'selected' : ''; ?>>Medio tiempo</option>
                    <option value="tiempo_completo" <?php echo ($voluntario['disponibilidad'] === 'tiempo_completo') ? 'selected' : ''; ?>>Tiempo completo</option>
                </select>
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