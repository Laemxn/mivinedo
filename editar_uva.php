<?php
session_start();
require_once 'config/db.php'; 

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Verificar si se ha pasado un ID de uva válido por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta para obtener los detalles de la uva a editar
    $stmt = $pdo->prepare("SELECT * FROM uvas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $usuario_id]);
    $uva = $stmt->fetch();

    // Si la uva no existe, redirigir a la página de gestión de uvas
    if (!$uva) {
        header('Location: gestion_uvas.php');
        exit();
    }
} else {
    // Si no se pasa el ID, redirigir a la página de gestión de uvas
    header('Location: gestion_uvas.php');
    exit();
}

// Procesar la actualización de la uva si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $fecha_plantacion = $_POST['fecha_plantacion'];
    $cuidados = $_POST['cuidados'];

    // Actualizar la uva en la base de datos
    $stmt = $pdo->prepare("UPDATE uvas SET nombre = ?, fecha_plantacion = ?, cuidados = ? WHERE id = ?");
    $stmt->execute([$nombre, $fecha_plantacion, $cuidados, $id]);

    // Redirigir a la página de gestión de uvas después de la actualización
    header('Location: gestion_uvas.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Uva - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Editar Uva</h2>
        <form action="editar_uva.php?id=<?= $uva['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Uva</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($uva['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_plantacion" class="form-label">Fecha de Plantación</label>
                <input type="date" id="fecha_plantacion" name="fecha_plantacion" class="form-control" value="<?= htmlspecialchars($uva['fecha_plantacion']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="cuidados" class="form-label">Cuidados</label>
                <textarea id="cuidados" name="cuidados" class="form-control" rows="4" required><?= htmlspecialchars($uva['cuidados']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Uva</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
