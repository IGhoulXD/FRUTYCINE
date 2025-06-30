<?php
include '../../Conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$idRol = $_POST['idRol'];

$sql = "UPDATE usuarios SET nombre=?, apellido=?, correo=?, direccion=?, idRol=? WHERE idUsuario=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $nombre, $apellido, $correo, $direccion, $idRol, $id);

$stmt->execute();
$stmt->close();
$conn->close();
?>
