<?php
session_start();
require_once 'Conexion/Conexion.php';

$correo = $_POST['correo'];
$contrasenia = $_POST['contrasenia'];

$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($contrasenia, $row['contrasenia'])) {
        $_SESSION['idUsuario'] = $row['idUsuario'];
        $_SESSION['nombre']    = $row['nombre'];
        $_SESSION['idRol']     = $row['idRol'];
        header("Location: bienvenida.php");
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Correo no registrado.";
}
?>
