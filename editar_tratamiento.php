<?php
session_start();
require 'config/db.php';  // Asegúrate de que el archivo de conexión esté correcto

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Verificar si el ID del tratamiento está en la URL
if (isset($_GET['id'])) {
    $tratamiento_id = $_GET['id'];

    // Consultar el tratamiento para editar
    $stmt = $pdo->prepare("SELECT * FROM tratamientos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$tratamiento_id, $usuario_id]);
    $tratamiento = $stmt->fetch();

    if (!$tratamiento) {
        // Si no se encuentra el tratamiento, redirigir
        header("Location: gestion_tratamientos.php");
        exit();
    }
} else {
    // Si no se pasa el ID, redirigir a la página de gestión de tratamientos
    header("Location: gestion_tratamientos.php");
    exit();
}

// Procesar la actualización del tratamiento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $fecha_aplicacion = $_POST['fecha_aplicacion'];
    $descripcion = $_POST['descripcion'];

    // Actualizar el tratamiento en la base de datos
    $updateQuery = "UPDATE tratamientos SET tipo = ?, fecha_aplicacion = ?, descripcion = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([$tipo, $fecha_aplicacion, $descripcion, $tratamiento_id]);

    // Redirigir a la página de gestión de tratamientos
    header("Location: gestion_tratamientos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tratamiento - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Editar Tratamiento</h2>

        <form method="POST">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Tratamiento</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?= htmlspecialchars($tratamiento['tipo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_aplicacion" class="form-label">Fecha de Aplicación</label>
                <input type="date" class="form-control" id="fecha_aplicacion" name="fecha_aplicacion" value="<?= htmlspecialchars($tratamiento['fecha_aplicacion']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?= htmlspecialchars($tratamiento['descripcion']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Tratamiento</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
