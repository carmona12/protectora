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

$idVoluntario = isset($_GET['id']) ? $_GET['id'] : null;


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idVoluntario = $_GET['id'];
// var_dump($idVoluntario);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nueva_area_de_interes = $_POST['nueva_area_de_interes'];
        $nueva_disponibilidad = $_POST['nueva_disponibilidad'];
        $nueva_fecha_ingreso = $_POST['nueva_fecha_ingreso'];

        try {
            $stmtModificarVoluntario = $conn->prepare("UPDATE voluntarios SET area_de_interes = :nueva_area_de_interes, disponibilidad = :nueva_disponibilidad, fecha_ingreso = :nueva_fecha_ingreso WHERE id_usuario = :id_voluntario");
            $stmtModificarVoluntario->bindParam(':nueva_area_de_interes', $nueva_area_de_interes);
            $stmtModificarVoluntario->bindParam(':nueva_disponibilidad', $nueva_disponibilidad);
            $stmtModificarVoluntario->bindParam(':nueva_fecha_ingreso', $nueva_fecha_ingreso);
            $stmtModificarVoluntario->bindParam(':id_voluntario', $idVoluntario, PDO::PARAM_INT);

            if ($stmtModificarVoluntario->execute()) {
                header("Location: gestionVoluntarios.php?exito=modificacion");
                exit();
            } else {
                header("Location: gestionVoluntarios.php?error=modificacion_fallo");
                exit();
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }
    
    // Obtener los datos actuales del socio
    $stmtVoluntario = $conn->prepare("SELECT * FROM voluntarios WHERE id_usuario = :idVoluntario");
    $stmtVoluntario->bindParam(':idVoluntario', $idVoluntario, PDO::PARAM_INT);
    $stmtVoluntario->execute();
    $datosVoluntario = $stmtVoluntario->fetch(PDO::FETCH_ASSOC);

    if (!$datosVoluntario) {
        header("Location: gestionVoluntarios.php?error=Voluntario_no_encontrado");
        exit();
    }
} else {
    header("Location: gestionVoluntarios.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Modificar Voluntario</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Modificar Voluntario</h1>
        <form method="post" action="">
            <div class="form-group mb-3">
                <label for="nueva_area_de_interes">Área de Interés:</label>
                <select class="form-select" id="nueva_area_de_interes" name="nueva_area_de_interes" required>
                    <option value="cuidado_animales" <?php echo ($datosVoluntario['area_de_interes'] === 'cuidado_animales') ? 'selected' : ''; ?>>Cuidado de animales</option>
                    <option value="eventos_recaudacion" <?php echo ($datosVoluntario['area_de_interes'] === 'eventos_recaudacion') ? 'selected' : ''; ?>>Eventos y recaudación de fondos</option>
                    <option value="educacion_concienciacion" <?php echo ($datosVoluntario['area_de_interes'] === 'educacion_concienciacion') ? 'selected' : ''; ?>>Educación y concienciación</option>
                    <option value="asistencia_administrativa" <?php echo ($datosVoluntario['area_de_interes'] === 'asistencia_administrativa') ? 'selected' : ''; ?>>Asistencia administrativa</option>
                    <option value="apoyo_refugios" <?php echo ($datosVoluntario['area_de_interes'] === 'apoyo_refugios') ? 'selected' : ''; ?>>Apoyo a refugios o albergues</option>
                    <option value="transporte_animales" <?php echo ($datosVoluntario['area_de_interes'] === 'transporte_animales') ? 'selected' : ''; ?>>Transporte de animales</option>
                    <option value="apoyo_tecnologico" <?php echo ($datosVoluntario['area_de_interes'] === 'apoyo_tecnologico') ? 'selected' : ''; ?>>Apoyo tecnológico</option>
                    <option value="diseno_grafico" <?php echo ($datosVoluntario['area_de_interes'] === 'diseno_grafico') ? 'selected' : ''; ?>>Diseño gráfico y medios visuales</option>
                    <option value="voluntariado_virtual" <?php echo ($datosVoluntario['area_de_interes'] === 'voluntariado_virtual') ? 'selected' : ''; ?>>Voluntariado virtual</option>
                    <option value="otros" <?php echo ($datosVoluntario['area_de_interes'] === 'otros') ? 'selected' : ''; ?>>Otros</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="disponibilidad">Disponibilidad:</label>
                <select class="form-select" id="nueva_disponibilidad" name="nueva_disponibilidad" required>
                    <option value="dias_especificos" <?php echo ($datosVoluntario['disponibilidad'] === 'dias_especificos') ? 'selected' : ''; ?>>Días específicos</option>
                    <option value="por_horas" <?php echo ($datosVoluntario['disponibilidad'] === 'por_horas') ? 'selected' : ''; ?>>Por horas específicas</option>
                    <option value="flexibilidad_horaria" <?php echo ($datosVoluntario['disponibilidad'] === 'flexibilidad_horaria') ? 'selected' : ''; ?>>Flexibilidad horaria</option>
                    <option value="fines_de_semana" <?php echo ($datosVoluntario['disponibilidad'] === 'fines_de_semana') ? 'selected' : ''; ?>>Fines de semana</option>
                    <option value="medio_tiempo" <?php echo ($datosVoluntario['disponibilidad'] === 'medio_tiempo') ? 'selected' : ''; ?>>Medio tiempo</option>
                    <option value="tiempo_completo" <?php echo ($datosVoluntario['disponibilidad'] === 'tiempo_completo') ? 'selected' : ''; ?>>Tiempo completo</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="nueva_fecha">Nueva fecha de ingreso:</label>
                <input type="date" class="form-control" name="nueva_fecha_ingreso" id="nueva_fecha_ingreso" value="<?php echo $datosVoluntario['fecha_ingreso']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="gestionVoluntarios.php" class="btn btn-secondary">Volver Atrás</a>
        </form>
    </div>
</body>

</html>