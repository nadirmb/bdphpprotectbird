<?php
session_start();

// verificamos si el usuario ha iniciado sesion
if (!isset($_SESSION['username'])) {
    exit("Debe iniciar sesión para guardar la puntuación."); // si no hay un usuario en la sesion se mostrara un mensaje y lo termina
}