<?php
include '../Conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_POST['id'];

$sql = "DELETE FROM usuarios WHERE idUsuario=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->close();
$conn->close();
?>
