<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.html");
    exit();
}
$rol = $_SESSION['idRol'];
$mensaje = "Bienvenido, " . $_SESSION['nombre'];
switch ($rol) {
    case 1: $mensaje .= " (Administrador)"; break;
    case 2: $mensaje .= " (Gerente)"; break;
    case 3: $mensaje .= " (Cliente)"; break;
}
echo "<h1>$mensaje</h1>";
echo '<a href="logout.php">Cerrar sesión</a>';
?>
