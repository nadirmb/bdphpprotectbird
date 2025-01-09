<?php
//archivo de configuracion para la conexion a la bsae de datos
require 'bd_conecion.php';

//funcion para agregar una nueva puntuacion
function agregarPuntuacion($conn) {
//validar datos enviados del formulario/cliente
if (isset($_POST['id_jugador']) && isset($_POST['puntuacion'])) {
    $id_jugador = intval($_POST['id_jugador']);
    $puntuacion = intval($_POST['puntuacion']);
}
// Insertar la puntuación en la base de datos
$sql = "INSERT INTO puntuaciones (jugador_id, puntuacion) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param($id_jugador, $puntuacion); // por seguridad utilizaremos bind_param 

if ($stmt->execute()) {
    echo "Puntuación agregada correctamente.";
} else {
    echo "Error al agregar la puntuación: " . $conn->error;
}
}

// cerrar la conexion a la base de datos al final 
$conn->close();
?>