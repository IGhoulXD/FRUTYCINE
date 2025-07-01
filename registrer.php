<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 
require_once 'BD/db.php';
require_once 'BD/csrf.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarTokenCSRF($_POST['csrf_token'])) {
        die('Token CSRF inválido.');
    }

    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $direccion = trim($_POST['direccion']);
    $clave = $_POST['password'];
    $rol = 3; // Fijo: Cliente

    if (strlen($nombre) >= 2 && strlen($clave) >= 6 && filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, correo, contrasenia, direccion, idRol) VALUES (?, ?, ?, ?, ?, ?)");
        try {
            $stmt->execute([$nombre, $apellido, $correo, $hash, $direccion ?: null, $rol]);
            $mensaje = "✅ Usuario registrado correctamente.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "❌ El correo ya está registrado.";
            } else {
                $mensaje = "❌ Error al registrar: " . $e->getMessage();
            }
        }
    } else {
        $mensaje = "❗ Datos inválidos. Asegúrate de que el correo sea válido y la contraseña tenga al menos 6 caracteres.";
    }
}

$token = generarTokenCSRF();
?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= $token ?>">

    <input type="text" name="nombre" placeholder="Nombre" required><br><br>
    <input type="text" name="apellido" placeholder="Apellido"><br><br>
    <input type="email" name="correo" placeholder="Correo electrónico" required><br><br>
    <input type="password" name="password" placeholder="Contraseña (mínimo 6 caracteres)" required><br><br>
    <input type="text" name="direccion" placeholder="Dirección (opcional)"><br><br>

    <button type="submit">Registrarse</button>
</form>

<p><?= htmlspecialchars($mensaje) ?></p>
