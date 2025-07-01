<?php
$conexion = new mysqli("localhost", "root", "", "cine");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recoger datos desde el frontend (JS via fetch POST)
$data = json_decode(file_get_contents("php://input"), true);

$nombre = $conexion->real_escape_string($data['nombre']);
$correo = $conexion->real_escape_string($data['correo']);
$asientos = $data['asientos']; // Array
$idFuncion = intval($data['idFuncion']);

// Paso 1: Verificamos si el usuario ya existe
$sqlUsuario = "SELECT idUsuario FROM usuarios WHERE correo = '$correo'";
$result = $conexion->query($sqlUsuario);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idUsuario = $row['idUsuario'];
} else {
    // Insertar usuario si no existe
    $conexion->query("INSERT INTO usuarios (nombre, correo, contrasenia, idRol) VALUES ('$nombre', '$correo', '1234', 3)");
    $idUsuario = $conexion->insert_id;
}

// Paso 2: Insertar los boletos
foreach ($asientos as $asiento) {
    $asiento = $conexion->real_escape_string($asiento);
    $conexion->query("INSERT INTO boletos (idFuncion, idUsuario, asiento) VALUES ($idFuncion, $idUsuario, '$asiento')");
}

echo json_encode(['status' => 'ok', 'mensaje' => 'Boletos guardados exitosamente']);
