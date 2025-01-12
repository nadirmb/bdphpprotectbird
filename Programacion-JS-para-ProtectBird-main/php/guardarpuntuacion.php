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