<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Productos</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <button id="menuToggle">&#9776;</button>

  <div class="sidebar">
    <a href="../Inicio/InicioGerente.php">Inicio</a>
    <a href="../Usuarios/Usuarios.php">Usuarios</a>
    <a href="../Pedidos/Pedidos.php">Pedidos</a>
    <a href="../Salas/Salas.php">Salas</a>
    <a href="../Reportes/Reportes.php">Reportes</a>
    <a href="../Inicio.html">Cerrar Sesión</a>
  </div>

  <div class="main-content">
    <header>
      <h1>Gestión de Productos</h1>
    </header>
  <div class="user-table"> 
    
    <div class="form-container">
      <h2>Agregar / Editar Producto</h2>
      <div class="form-wrapper">
      <form id="productoForm">
        <input type="hidden" id="productoId">
        <input type="text" id="nombre" placeholder="Nombre" required>
        <input type="number" id="precio" placeholder="Precio" required>
        <input type="text" id="descripcion" placeholder="Descripción">
        <input type="file" id="imagen_id" placeholder="ID de Imagen">
        <button type="submit">Guardar</button>
      </form>
      
    </div>
     </div>
    <table id="productosTable">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Descripción</th>
          <th>Imagen </th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
   </div>
    <div id="mensaje" class="mensaje-flotante"></div>
  </div>

  <script src="productos.js"></script>
</body>
</html>
