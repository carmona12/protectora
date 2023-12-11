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
// Obtener las especies de la base de datos
$stmtEspecies = $conn->prepare("SELECT * FROM especies");
$stmtEspecies->execute();
$especies = $stmtEspecies->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Especies</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <style>
        .thumbnail {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>

<body>
    <section class="container mt-4 contenido-principal">
        <div class="row">
            <div class="col-md-8">
                <h2>Lista de Especies</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Foto Especie</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($especies as $especie) : ?>
                            <tr>
                                <td><?php echo $especie['id']; ?></td>
                                <td><?php echo $especie['especie']; ?></td>
                                <td>
                                    <img src="../<?php echo $especie['foto_especie']; ?>" alt="" class="thumbnail">
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm mb-1" onclick="confirmarEliminar(<?php echo $especie['id']; ?>)">Eliminar</button>
                                    <button class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modificarEspecieModal_<?php echo $especie['id']; ?>">Modificar</button>
                                </td>
                            </tr>
                            <!-- Modal de modificar especie -->
                            <div class="modal fade" id="modificarEspecieModal_<?php echo $especie['id']; ?>" tabindex="-1" aria-labelledby="modificarEspecieModalLabel_<?php echo $especie['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modificarEspecieModalLabel_<?php echo $especie['id']; ?>">Modificar Especie</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="modificar_especie.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $especie['id']; ?>">

                                                <div class="mb-3">
                                                    <label for="nombre_especie" class="form-label">Nuevo Nombre de la Especie:</label>
                                                    <input type="text" class="form-control" id="nombre_especie" name="nombre_especie" value="<?php echo $especie['especie']; ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="foto_especie" class="form-label">Nueva Foto de la Especie (URL):</label>
                                                    <input type="text" class="form-control" id="foto_especie" name="foto_especie" value="<?php echo $especie['foto_especie']; ?>">
                                                </div>

                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-8">

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaEspecieModal">
                    Crear Nueva Especie
                </button>

                <!----------------- Modal de nueva especie ------------->
                <div class="modal fade" id="nuevaEspecieModal" tabindex="-1" aria-labelledby="nuevaEspecieModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevaEspecieModalLabel">Nueva Especie</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="nueva_especie.php" method="post">

                                    <div class="mb-3">
                                        <label for="nombre_especie" class="form-label">Nombre de la Especie:</label>
                                        <input type="text" class="form-control" id="nombre_especie" name="nombre_especie" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="foto_especie" class="form-label">Foto de la Especie (URL):</label>
                                        <input type="text" class="form-control" id="foto_especie" name="foto_especie">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Guardar Especie</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="gestionAnimales.php" class="btn btn-secondary">Volver Atrás</a>
            </div>
        </div>
    </section>
</body>
<script>
    function confirmarEliminar(id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta especie?")) {
            window.location.href = "eliminar_especie.php?id=" + id;
        }
    }
</script>

</html>