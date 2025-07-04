<?php
header('Content-Type: application/json'); 

include '../../Conexion.php';

$productos = [];

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    echo json_encode($productos);
} else {
    echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
}

$conn->close();
?>
