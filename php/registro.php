<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="procesar_registro.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="text" name="apellido" placeholder="Apellido"><br>
        <input type="email" name="correo" placeholder="Correo" required><br>
        <input type="password" name="contrasenia" placeholder="Contraseña" required><br>
        <input type="text" name="direccion" placeholder="Dirección"><br>
        <select name="idRol" required>
            <option value="">Seleccione un rol</option>
            <option value="3">Cliente</option>
        </select><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>
