// gestion_inventarios.php
require_once 'config/db.php';

function agregarUva($variedad, $cantidad, $fecha) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO inventarios (variedad, cantidad, fecha) VALUES (?, ?, ?)");
    $stmt->execute([$variedad, $cantidad, $fecha]);
}

function consultarInventario() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM inventarios");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function actualizarInventario($id, $cantidad) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE inventarios SET cantidad = ? WHERE id = ?");
    $stmt->execute([$cantidad, $id]);
}

function eliminarUva($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM inventarios WHERE id = ?");
    $stmt->execute([$id]);
}
