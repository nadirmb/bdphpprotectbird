<?php
session_start(); // Iniciar sesion o la deja mantenida si ya esta iniciada

// quitar todas las variables de sesión
session_unset();

// quiitar la sesion
session_destroy();

// Redirigir al inicio
header("Location:https://localhost/Programacion-JS-para-ProtectBird-main/html/iniciarsesion.html");
exit();
?>
