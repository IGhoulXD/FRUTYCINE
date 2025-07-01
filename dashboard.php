<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

echo "Bienvenido, " . htmlspecialchars($_SESSION['user']['nombre']) . "<br>";
echo "Rol: " . htmlspecialchars($_SESSION['user']['rol']) . "<br>";
echo "<a href='logout.php'>Cerrar sesión</a>";
