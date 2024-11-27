<?php
// Incluir archivo de configuración que hicimos anteriormente
include 'bd_conecion.php';

// hacer la consulta para insertar un nuevo jugador
$sql = "INSERT INTO jugadores (nombre, correo, contraseña) VALUES (:nombre, :correo, :contraseña)";
$stmt = $pdo->prepare($sql);

// vincular los parametros
// Para vincular los parametros utilizaremos bindparam para poder vincular un valor a un parametro en una sentencia
// y asin los valores seran pasador de froma segura a la consulta
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':contraseña', $contraseña);