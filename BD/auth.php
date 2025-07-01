<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario está logueado
function usuarioAutenticado(): bool {
    return isset($_SESSION['usuario_id']);
}

// Redirige al login si no está autenticado
function protegerRuta(): void {
    if (!usuarioAutenticado()) {
        header('Location: ../login.php');
        exit;
    }
}

// Obtener nombre de usuario
function obtenerNombreUsuario(): string {
    return $_SESSION['usuario_nombre'] ?? 'Invitado';
}

// Cerrar sesión
function cerrarSesion(): void {
    session_unset();
    session_destroy();
    header('Location: ../login.php');
    exit;
}
