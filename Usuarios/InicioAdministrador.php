<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Panel de Usuarios - Administrador</title>
 <link rel="stylesheet" href="estilos.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
 
  <button id="menuToggle">&#9776;</button>

 
  <div class="sidebar">
    <a href="Usuarios.php">Usuarios</a>
    <a href="productos.php">Productos</a>
    <a href="pedidos.php">Pedidos</a>
    <a href="salas.php">Salas</a>
    <a href="Gerentes.php">Gerentes</a>
    <a href="Reportes.php">Reportes</a>
    <a href="Inicio.html">Cerrar Sesión</a>
  </div>

  <div class="main-content">
    <!-- Header -->
    <header>
      <h1>Panel de Control</h1>
      <h2>Bienvenido al panel de administrador</h2>
      <p>Aquí puedes gestionar todo el contenido de la página.</p>
    </header>

    <!-- Tabla de usuarios -->
    <div class="user-table">
      <h3>Usuarios Registrados</h3>
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Rol</th>
          </tr>
        </thead>
        <tbody id="tablaUsuarios">
          <tr><td colspan="5">Cargando usuarios...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Script para cargar usuarios -->
  <script>
    $(document).ready(function () {
      $.ajax({
        url: 'get_usuarios.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          let html = '';
          if (data.length > 0) {
            $.each(data, function (i, user) {
              html += '<tr>';
              html += '<td>' + user.nombre + '</td>';
              html += '<td>' + user.apellido + '</td>';
              html += '<td>' + user.correo + '</td>';
              html += '<td>' + user.nombreRol + '</td>';
              html += '</tr>';
            });
          } else {
            html = '<tr><td colspan="5">No se encontraron usuarios.</td></tr>';
          }
          $('#tablaUsuarios').html(html);
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar usuarios:", error);
          $('#tablaUsuarios').html('<tr><td colspan="5">Error al cargar usuarios</td></tr>');
        }
      });
    }); 
    document.getElementById('menuToggle').addEventListener('click', function () {
      document.body.classList.toggle('menu-open');
    });
  </script>
</body>
</html>
