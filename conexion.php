<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "illumina";

$conn = new mysqli(
    $host,
    $usuario,
    $contrasena,
    $base_datos
);

if ($conn->connect_error) {
    die("Error de conexión con Illumina. Verifica XAMPP y MySQL.");
}

$conn->set_charset("utf8mb4");

?>