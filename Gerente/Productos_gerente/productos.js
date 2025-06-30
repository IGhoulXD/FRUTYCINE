document.addEventListener('DOMContentLoaded', function () {
  const tabla = document.querySelector('#productosTable tbody');
  const form = document.getElementById('productoForm');
  const mensaje = document.getElementById('mensaje');
  const vistaPrevia = document.getElementById('imagenPrevia');

  function mostrarMensaje(texto) {
    mensaje.textContent = texto;
    mensaje.style.display = 'block';
    setTimeout(() => mensaje.style.display = 'none', 3000);
  }

  function cargarProductos() {
    fetch('get_productos.php')
      .then(res => res.json())
      .then(data => {
        tabla.innerHTML = '';
        data.forEach(p => {
          const fila = document.createElement('tr');
          fila.innerHTML = `
            <td>${p.nombre}</td>
            <td>$${p.precio}</td>
            <td>${p.descripcion}</td>
            <td><img src="../../ImagenesDeProductos/${p.imagen_id}" width="80" alt="Imagen"></td>
            <td>
              <button onclick="editarProducto('${p.idProducto}', '${p.nombre}', '${p.precio}', '${p.descripcion}', '${p.imagen_id}')">Editar</button>
              <button onclick="eliminarProducto(${p.idProducto})">Eliminar</button>
            </td>
          `;
          tabla.appendChild(fila);
        });
      });
  }

  window.editarProducto = (id, nombre, precio, descripcion, imagen_id) => {
    document.getElementById('productoId').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('precio').value = precio;
    document.getElementById('descripcion').value = descripcion;

    if (imagen_id && vistaPrevia) {
      vistaPrevia.src = `../../ImagenesDeProductos/${imagen_id}`;
      vistaPrevia.style.display = 'block';
    }
  };

  window.eliminarProducto = id => {
    fetch('eliminar_producto.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
      mostrarMensaje(data.mensaje);
      cargarProductos();
    });
  };

  form.addEventListener('submit', e => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('id', document.getElementById('productoId').value);
    formData.append('nombre', document.getElementById('nombre').value);
    formData.append('precio', document.getElementById('precio').value);
    formData.append('descripcion', document.getElementById('descripcion').value);

    const archivoImagen = document.getElementById('imagen_id').files[0];
    if (archivoImagen) {
      formData.append('imagen', archivoImagen);
    }

    const url = formData.get('id') ? 'actualizar_producto.php' : 'agregar_producto.php';

    fetch(url, {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      mostrarMensaje(data.mensaje);
      form.reset();
      document.getElementById('productoId').value = '';
      if (vistaPrevia) vistaPrevia.style.display = 'none';
      cargarProductos();
    })
    .catch(err => {
      mostrarMensaje("Error inesperado al guardar.");
      console.error(err);
    });
  });
   document.getElementById('imagen_id').addEventListener('change', function () {
  const file = this.files[0];
  const vista = document.getElementById('imagenPrevia');
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      vista.src = e.target.result;
      vista.style.display = 'block';
    };
    reader.readAsDataURL(file);
  } else {
    vista.style.display = 'none';
  }
});

  cargarProductos();
  document.getElementById('menuToggle').addEventListener('click', function () {
      document.body.classList.toggle('menu-open');
    });
});



 