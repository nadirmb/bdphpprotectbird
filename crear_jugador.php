<?php
// Incluir archivo de configuración que hicimos anteriormente
include 'bd_conecion.php';

// hacer la consulta para insertar un nuevo jugador
$sql = "INSERT INTO jugadores (nombre, correo, contraseña) VALUES (:nombre, :correo, :contraseña)";
$stmt = $pdo->prepare($sql);