<?php
//archivo de configuracion para la conexion a la bsae de datos
require 'bd_conecion.php';

//funcin para agregar una nueva puntuacion
function agregarPuntuacion($conn) {
//validar datos enviados del formulario/cliente
if (isset($_POST['id_jugador']) && isset($_POST['puntuacion'])) {
    $id_jugador = intval($_POST['id_jugador']);
    $puntuacion = intval($_POST['puntuacion']);
}
}