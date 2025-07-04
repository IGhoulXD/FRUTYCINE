<?php
include '../Conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT u.idUsuario, u.nombre, u.apellido, u.correo, u.direccion, r.nombreRol, u.idRol
        FROM usuarios u
        JOIN roles r ON u.idRol = r.idRol";

$result = $conn->query($sql);
$usuarios = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

echo json_encode($usuarios);
$conn->close();
?>
