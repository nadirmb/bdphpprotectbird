<?php
session_start();

// comprovar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // si no hay una sesión activa, redirigir a la página de inicio de sesion
    header("Location:https://localhost/Programacion-JS-para-ProtectBird-main/html/iniciarsesion.html");
    exit();
}
