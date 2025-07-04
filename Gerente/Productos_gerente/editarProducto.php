<?php
include '../../Conexion.php';

// Función para procesar imagen solo si se envía una nueva
function procesarImagen() {
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        return null; // No se subió nueva imagen
    }

    $mime = mime_content_type($_FILES['imagen']['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png'])) {
        throw new Exception('Formato de imagen no válido. Solo JPG o PNG.');
    }

    $imagen_id = uniqid();
    $extension = $mime === 'image/png' ? '.png' : '.jpg';
    $nombreFinal = $imagen_id . $extension;
    $destino = 'ImagenesDeProductos/' . $nombreFinal;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
        throw new Exception('Error al guardar la imagen en el servidor.');
    }

    return $nombreFinal;
}

try {
    // Datos obligatorios
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    // Imagen (opcional)
    $imagen_id = procesarImagen();

    if ($imagen_id) {
        // Actualizar también la imagen
        $sql = "UPDATE productos SET nombre=?, precio=?, descripcion=?, imagen_id=? WHERE idProducto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssi", $nombre, $precio, $descripcion, $imagen_id, $id);
    } else {
        // No actualizar la imagen
        $sql = "UPDATE productos SET nombre=?, precio=?, descripcion=? WHERE idProducto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdsi", $nombre, $precio, $descripcion, $id);
    }

    if ($stmt->execute()) {
        echo "Producto actualizado correctamente";
    } else {
        echo "Error al actualizar";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
