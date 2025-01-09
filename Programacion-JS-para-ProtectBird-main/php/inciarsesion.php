<?php
session_start(); 

// comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    // conectar a la base de datos
    $host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $dbname = "protect_bird_db";
    $conn = new mysqli($host, $db_user, $db_pass, $dbname);
    
    // comprobar si la conexión ha sido correcta
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    
}