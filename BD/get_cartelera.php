<?php
header('Content-Type: application/json');
$fecha = $_GET['fecha'] ?? date('Y-m-d');

// Aquí haces consulta a BD o devuelves cartelera estática para pruebas
$cartelera = [
    [
        "titulo" => "Your name",
        "imagen" => "img/yourname.png",
        "horarios" => ["13:00", "16:00", "19:00"]
    ],
    [
        "titulo" => "demon slayer infinity castle",
        "imagen" => "img/image.png",
        "horarios" => ["12:00", "15:30", "20:00"]
    ]
];

echo json_encode($cartelera);
