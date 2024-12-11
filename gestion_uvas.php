<?php
session_start();
require_once 'config/db.php'; 
include 'partials/navbar.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta SQL actualizada para obtener nombre, fecha de plantación y cuidados
$stmt = $pdo->prepare("SELECT * FROM uvas WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$uvas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Uvas - Mi Viñedo Digital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Gestionar Uvas</h2>
        <a href="nueva_uva.php" class="btn btn-success mb-3">Añadir Nueva Uva</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre de la Uva</th>
                    <th>Fecha de Plantación</th>
                    <th>Cuidados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($uvas as $uva): ?>
                    <tr>
                        <!-- Mostramos los valores de nombre, fecha de plantación y cuidados -->
                        <td><?= htmlspecialchars($uva['nombre']) ?></td>
                        <td><?= htmlspecialchars($uva['fecha_plantacion']) ?></td>
                        <td><?= htmlspecialchars($uva['cuidados']) ?></td>
                        <td>
                            <!-- Botones de acción para editar y eliminar -->
                            <a href="editar_uva.php?id=<?= $uva['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_uva.php?id=<?= $uva['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta uva?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
