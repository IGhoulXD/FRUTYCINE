<?php

require_once 'config.php';

try{

$pdo = new PDO(
'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
DB_USER,
DB_PASS,[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
}
catch (PDOException $e) {
    // Registra error pero no lo muestra al usuario
    error_log("DB Connection Error: " . $e->getMessage());
    die("Error de conexión con la base de datos.");
}