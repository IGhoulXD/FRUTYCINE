const p = new URLSearchParams(window.location.search);

document.getElementById("pelicula").innerText = "🎬 Película: " + p.get("pelicula");
document.getElementById("fecha").innerText = "📅 Fecha: " + p.get("fecha");
document.getElementById("hora").innerText = "🕒 Hora: " + p.get("hora");
document.getElementById("nombre").innerText = "👤 Nombre: " + p.get("nombre");
document.getElementById("correo").innerText = "📧 Correo: " + p.get("correo");
document.getElementById("asientos").innerText = "💺 Asientos: " + p.get("asientos");
document.getElementById("combo").innerText = "🍿 Combo: " + p.get("combo") + " x" + p.get("cantidad");
