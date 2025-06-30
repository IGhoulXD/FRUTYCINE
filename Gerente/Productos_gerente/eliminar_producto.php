<?php
header('Content-Type: application/json');
include '../../Conexion.php'; 

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$sql = "DELETE FROM productos WHERE idProducto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensaje' => 'Producto eliminado correctamente']);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al eliminar el producto']);
}

$conn->close();
?>
