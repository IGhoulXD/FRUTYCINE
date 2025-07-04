<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <button id="menuToggle">&#9776;</button>

  <div class="sidebar">
    <a href="../Inicio/InicioAdministrador.php">Inicio</a>
    <a href="../Productos/productos.php">Productos</a>
    <a href="../Productos/pedidos.php">Pedidos</a>
    <a href="../Productos/salas.php">Salas</a>
    <a href="../Productos/Gerentes.php">Gerentes</a>
    <a href="../Productos/Reportes.php">Reportes</a>
    <a href="InicioAdministrador.php">Cerrar Sesión</a>
  </div>

  <div class="main-content">
    <header>
      <h1>Administrar Usuarios</h1>
    </header>

    <div class="producto-table">
      <h3>Usuarios</h3>
      <div class="buscador-wrapper">
       <input type="text" id="buscadorNombre" placeholder="Buscar por nombre...">
      </div>
      <div class="form-wrapper">
        <form id="formUsuario">
          <input type="hidden" id="id" name="id">
          <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
          <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
          <input type="email" id="correo" name="correo" placeholder="Correo" required>
          <input type="text" id="direccion" name="direccion" placeholder="Dirección" required>
          <input type="password" id="contrasenia" name="contrasenia" placeholder="Contraseña" required>
          <select id="idRol" name="idRol" required>
            <option value="">Selecciona Rol</option>
            <option value="1">Administrador</option>
            <option value="2">Gerente</option>
            <option value="3">Cliente</option>
          </select>
          <button type="submit" class="btn-editar">Guardar</button>
        </form>
      </div>

      <table id="tablaUsuarios">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <script>
    const form = document.getElementById('formUsuario');
    const tabla = document.querySelector('#tablaUsuarios tbody');
    const buscador = document.getElementById('buscadorNombre');
    let listaUsuarios = [];

    function cargarUsuarios() {
      fetch('get_usuarios.php')
        .then(res => res.json())
        .then(data => {
          listaUsuarios = data;
          mostrarUsuarios(listaUsuarios);
        });
    }

    function mostrarUsuarios(usuarios) {
      tabla.innerHTML = '';
      usuarios.forEach(u => {
        tabla.innerHTML += `
          <tr>
            <td>${u.nombre}</td>
            <td>${u.apellido}</td>
            <td>${u.correo}</td>
            <td>${u.direccion}</td>
            <td>${u.nombreRol}</td>
            <td>
              <button class="btn-editar" onclick='editar(${JSON.stringify(u)})'>Editar</button>
              <button class="btn-eliminar" onclick='eliminar(${u.idUsuario})'>Eliminar</button>
            </td>
          </tr>`;
      });
    }

    function editar(usuario) {
      document.getElementById('id').value = usuario.idUsuario;
      document.getElementById('nombre').value = usuario.nombre;
      document.getElementById('apellido').value = usuario.apellido;
      document.getElementById('correo').value = usuario.correo;
      document.getElementById('direccion').value = usuario.direccion;
      document.getElementById('contrasenia').disabled = true;
      document.getElementById('idRol').value = usuario.idRol;
      document.getElementById('contrasenia').value = '';
    }

    function eliminar(idUsuario) {
      fetch('eliminar_usuario.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${idUsuario}`
      })
      .then(() => {
        mostrarMensaje("Usuario eliminado correctamente");
        cargarUsuarios();
      });
    }

  form.addEventListener('submit', function (e) {
  e.preventDefault();
  const datos = new FormData(form);
  const esEdicion = datos.get('id') !== "";
  const url = esEdicion ? 'editar_usuario.php' : 'agregar_usuario.php';

  if (!esEdicion) {
    document.getElementById('contrasenia').disabled = false;
  }

  fetch(url, {
    method: 'POST',
    body: datos
  })
  .then(res => res.text())
  .then(() => {
    form.reset();
    document.getElementById('contrasenia').disabled = false; 
    cargarUsuarios();
    mostrarMensaje(esEdicion ? "Usuario actualizado correctamente" : "Usuario agregado correctamente");
  });
});


    function mostrarMensaje(texto) {
      let mensaje = document.createElement("div");
      mensaje.className = "mensaje-flotante";
      mensaje.innerText = texto;
      mensaje.style.position = "fixed";
      mensaje.style.top = "50%";
      mensaje.style.left = "50%";
      mensaje.style.transform = "translate(-50%, -50%)";
      mensaje.style.background = "#444";
      mensaje.style.color = "#fff";
      mensaje.style.padding = "10px 20px";
      mensaje.style.borderRadius = "8px";
      mensaje.style.zIndex = "9999";
      document.body.appendChild(mensaje);
      setTimeout(() => mensaje.remove(), 3000);
    }

    buscador.addEventListener('input', function () {
      const texto = this.value.toLowerCase();
      const filtrados = listaUsuarios.filter(u =>
        u.nombre.toLowerCase().includes(texto)
      );
      mostrarUsuarios(filtrados);
    });

    document.getElementById('menuToggle').addEventListener('click', () => {
      document.body.classList.toggle('menu-open');
    });

    cargarUsuarios();
  </script>
</body>
</html>
