const params = new URLSearchParams(window.location.search);
const pelicula = params.get('pelicula');
const hora = params.get('hora');
const fecha = params.get('fecha');
const idFuncion = params.get('idFuncion'); // Necesario para identificar la función

document.getElementById('info-reserva').innerText = `Película: ${pelicula} | Fecha: ${fecha} | Hora: ${hora}`;

const filas = ['A','B','C','D','E','F','G','H','I','J'];
const columnas = 10;
const asientosContainer = document.getElementById('asientos');
const seleccionados = new Set();
let ocupados = [];

function renderAsientos() {
  asientosContainer.innerHTML = ""; // Limpia el contenedor antes de renderizar
  filas.forEach(fila => {
    for (let col = 1; col <= columnas; col++) {
      const id = fila + col;
      const btn = document.createElement('div');
      btn.innerText = id;
      btn.className = 'asiento';
      if (ocupados.includes(id)) {
        btn.classList.add('ocupado');
      } else {
        btn.classList.add('disponible');
        btn.onclick = () => {
          if (btn.classList.contains('seleccionado')) {
            btn.classList.remove('seleccionado');
            seleccionados.delete(id);
          } else {
            btn.classList.add('seleccionado');
            seleccionados.add(id);
          }
          document.getElementById('continuarBtn').style.display = seleccionados.size > 0 ? 'inline-block' : 'none';
        };
      }
      asientosContainer.appendChild(btn);
    }
  });
}

// 🔄 Obtener asientos ocupados dinámicamente desde PHP
fetch(`get_ocupados.php?idFuncion=${idFuncion}`)
  .then(res => res.json())
  .then(data => {
    ocupados = data;
    renderAsientos();
  });

document.getElementById('continuarBtn').onclick = () => {
  document.getElementById('formulario-datos').style.display = 'block';
  document.getElementById('info-seleccion').innerText =
    `Película: ${pelicula} | Fecha: ${fecha} | Hora: ${hora}\nAsientos: ${Array.from(seleccionados).join(', ')}`;
};

document.getElementById('formulario-datos').onsubmit = function(e) {
  e.preventDefault();
  const combo = document.getElementById('combo').value || "Ninguno";
  const cantidad = document.getElementById('cantidad').value || "0";
  const nombre = document.getElementById('nombre').value;
  const correo = document.getElementById('correo').value;
  const asientos = Array.from(seleccionados).join(', ');

 fetch('BD/get_ocupados.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    nombre,
    correo,
    asientos: Array.from(seleccionados),
    idFuncion: idFuncion
  })
})
.then(res => res.json())
.then(data => {
  if (data.status === 'ok') {
    // redirigir solo si se guardó bien
    const url = new URL("ticket.html", window.location.origin);
    url.searchParams.set("pelicula", pelicula);
    url.searchParams.set("fecha", fecha);
    url.searchParams.set("hora", hora);
    url.searchParams.set("nombre", nombre);
    url.searchParams.set("correo", correo);
    url.searchParams.set("asientos", Array.from(seleccionados).join(', '));
    url.searchParams.set("combo", combo);
    url.searchParams.set("cantidad", cantidad);
    url.searchParams.set("idFuncion", idFuncion);
    window.location.href = url;
  } else {
    alert("Error al guardar la reserva.");
  }
});

};
