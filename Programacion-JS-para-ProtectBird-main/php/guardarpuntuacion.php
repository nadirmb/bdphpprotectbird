<?php
session_start();

// verificamos si el usuario ha iniciado sesion
if (!isset($_SESSION['username'])) {
    exit("Debe iniciar sesión para guardar la puntuación."); // si no hay un usuario en la sesion se mostrara un mensaje y lo termina
}

// verificamos si la petición es POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("El metodo no es permitido."); // si no es una peticion POST se muestra un mensaje de error y termina la ejecuiion
}

// recibimos los datos enviados desde el formulario
$puntuacionNueva = intval($_POST['puntuacion']); // usamos el intval ya que con esto convertimos la puntuación recibida en un número entero y nos asseguramos que los datos se han manejadoo corectament
$username = $_SESSION['username']; // recuperramos el nombre de usuario desde la sesion