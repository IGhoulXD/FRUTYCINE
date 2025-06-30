<?php
include '../../Conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$contrasenia = $_POST['contrasenia'];
$idRol = $_POST['idRol'];

$hashed = password_hash($contrasenia, PASSWORD_DEFAULT);
$sql = "INSERT INTO usuarios (nombre, apellido, correo, contrasenia, direccion, idRol)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $nombre, $apellido, $correo, $hashed, $direccion, $idRol);
$stmt->execute();

$stmt->close();
$conn->close();
?>
