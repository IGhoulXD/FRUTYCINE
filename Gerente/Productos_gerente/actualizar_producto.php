<?php
include '../../Conexion.php'; 
header('Content-Type: application/json');

function procesarImagen() {
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $mime = mime_content_type($_FILES['imagen']['tmp_name']);
    if ($mime !== 'image/jpeg' && $mime !== 'image/png') {
        throw new Exception('Formato de imagen no válido. Solo JPG o PNG.');
    }

    $imagen_id = uniqid();
    $extension = $mime === 'image/png' ? '.png' : '.jpg';
    $destino = '../ImagenesDeProductos/' . $imagen_id . $extension;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
        throw new Exception('No se pudo guardar la imagen.');
    }

    return $imagen_id . $extension;
}

try {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $imagen_id = procesarImagen(); // Puede ser null

    if ($imagen_id) {
        $sql = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, imagen_id = ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssi", $nombre, $precio, $descripcion, $imagen_id, $id);
    } else {
        $sql = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdsi", $nombre, $precio, $descripcion, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'ok', 'mensaje' => 'Producto actualizado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'Error al actualizar producto']);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'mensaje' => $e->getMessage()]);
}

$conn->close();
?>
