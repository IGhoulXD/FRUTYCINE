<?php
include '../../Conexion.php';
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

function procesarImagen() {
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        return null; 
    }

    $mime = mime_content_type($_FILES['imagen']['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png'])) {
        throw new Exception('Formato de imagen no válido. Solo JPG o PNG.');
    }

    if (!file_exists('../../ImagenesDeProductos')) {
        throw new Exception('La carpeta ImagenesDeProductos no existe.');
    }

    if (!is_writable('../../ImagenesDeProductos')) {
        throw new Exception('La carpeta ImagenesDeProductos no tiene permisos de escritura.');
    }

    $imagen_id = uniqid();
    $extension = $mime === 'image/png' ? '.png' : '.jpg';
    $destino = '../../ImagenesDeProductos/' . $imagen_id . $extension;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
        throw new Exception('No se pudo guardar la imagen en el servidor.');
    }

    return $imagen_id . $extension;
}

try {
    
    if (empty($_POST['nombre']) || empty($_POST['precio'])) {
        throw new Exception('Nombre y precio son obligatorios.');
    }

    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $imagen_id = procesarImagen();

    $sql = "INSERT INTO productos (nombre, precio, descripcion, imagen_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdss", $nombre, $precio, $descripcion, $imagen_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'ok', 'mensaje' => 'Producto agregado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'Error al guardar en la base de datos']);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'mensaje' => $e->getMessage()]);
}

$conn->close();
?>
