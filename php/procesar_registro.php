<?php
require_once 'Conexion/Conexion.php';

$nombre      = $_POST['nombre'];
$apellido    = $_POST['apellido'];
$correo      = $_POST['correo'];
$contrasenia = password_hash($_POST['contrasenia'], PASSWORD_DEFAULT);
$direccion   = $_POST['direccion'];
$idRol       = $_POST['idRol'];

$sql = "INSERT INTO usuarios (nombre, apellido, correo, contrasenia, direccion, idRol)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $nombre, $apellido, $correo, $contrasenia, $direccion, $idRol);

if ($stmt->execute()) {
    echo "Usuario registrado exitosamente. <a href='login.html'>Iniciar sesión</a>";
} else {
    echo "Error: " . $stmt->error;
}
$conn->close();
?>
