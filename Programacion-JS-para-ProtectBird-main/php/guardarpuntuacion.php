<?php
session_start();

// primero comprobamos si el usuario ha iniciado sesion sino ha iniciado sesion que salga un mensaje
if (!isset($_SESSION['username'])) {
    exit("Debe iniciar sesión para guardar la puntuación.");
}
