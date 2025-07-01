const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
const meses = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];

const BASE_URL = 'http://127.0.0.1/proyectoFinal/BD';
window.onload = () => {
  for (let i = 0; i <= 5; i++) {
    const fecha = new Date();
    fecha.setDate(fecha.getDate() + i);
    const diaNombre = diasSemana[fecha.getDay()];
    const dia = fecha.getDate();
    const mes = meses[fecha.getMonth()];

    if (i >= 2) {
      document.getElementById(`texto${i}`).innerText = diaNombre;
    }

    document.getElementById(`fecha${i}`).innerText = `${dia} ${mes}`;
  }

  cargarDiaOffset(0); // Cargar cartelera de hoy al iniciar
};

function cargarDiaOffset(offset) {
  const fecha = new Date();
  fecha.setDate(fecha.getDate() + offset);
  const fechaStr = fecha.toISOString().split('T')[0];
fetch(`${BASE_URL}/get_cartelera.php?fecha=${fechaStr}`)

    .then(res => res.json())
    .then(cartelera => {
      renderCartelera(cartelera, fechaStr);
    })
    .catch(() => {
      document.getElementById('tabla-cartelera').innerHTML = '<p>Error cargando la cartelera.</p>';
    });
}

function renderCartelera(cartelera, fecha) {
  let html = `<table border="1" style="margin-top:20px; width:90%; margin-left:auto; margin-right:auto; text-align:center;">
    <tr><th>Película</th><th>Horarios disponibles</th></tr>`;

  cartelera.forEach(pelicula => {
    html += `<tr>
      <td>
        <img src="${pelicula.imagen}" alt="${pelicula.titulo}" style="width:120px; height:auto; border-radius:10px;"><br>
        <strong>${pelicula.titulo}</strong>
      </td>
      <td>
        ${pelicula.horarios.map(h =>
          `<button onclick="seleccionarHorario('${pelicula.titulo}', '${h}', '${fecha}')">${h}</button>`
        ).join('<br>')}
      </td>
    </tr>`;
  });

  html += `</table>`;
  document.getElementById('tabla-cartelera').innerHTML = html;
}

function seleccionarHorario(pelicula, hora, fecha) {
  const url = `formulario.html?pelicula=${encodeURIComponent(pelicula)}&hora=${encodeURIComponent(hora)}&fecha=${encodeURIComponent(fecha)}`;
  window.location.href = url;
}
