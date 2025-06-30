<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="validar_login.php" method="POST">
        <input type="email" name="correo" placeholder="Correo" required><br>
        <input type="password" name="contrasenia" placeholder="Contraseña" required><br>
        <button type="submit">Entrar</button>
    </form>
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
</body>
</html>
