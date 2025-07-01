<?php
error_reporting(E_ALL & ~E_NOTICE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'bd/db.php';     // tu conexión PDO aquí
require_once 'bd/csrf.php';   // funciones csrf (generarTokenCSRF, verificarTokenCSRF)

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarTokenCSRF($_POST['csrf_token'])) {
        die('Token CSRF inválido.');
    }

    $usuario = trim($_POST['username']);
    $clave = $_POST['password'];

    // Buscar por correo porque en formulario pides "username" pero la DB tiene correo
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();

    if ($user) {
        // Para contraseñas en texto plano (no recomendado)
        if ($clave === $user['contrasenia']) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => $user['idUsuario'],
                'nombre' => $user['nombre'],
                'rol' => $user['idRol']
            ];
            header('Location: dashboard.php');
            exit;
        } else {
            $mensaje = "❌ Usuario o contraseña incorrectos.";
        }
    } else {
        $mensaje = "❌ Usuario o contraseña incorrectos.";
    }
}

$token = generarTokenCSRF();
?>

<form method="POST" autocomplete="off">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
    <input type="text" name="username" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Iniciar sesión</button>
</form>
<p><?= htmlspecialchars($mensaje) ?></p>

<!-- BOTÓN PARA IR A REGISTRO -->
<div style="margin-top: 20px;">
    <p>¿No tienes cuenta?</p>
    <a href="registrer.php">
        <button>Registrarse</button>
    </a>
</div>