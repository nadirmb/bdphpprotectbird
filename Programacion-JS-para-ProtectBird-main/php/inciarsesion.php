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
// consultar si el nombre de usuario existe en la base de datos
  $stmt = $conn->prepare("SELECT * FROM jugadores WHERE nombre = ?");
  $stmt->bind_param("s", $user); // 's' es para decir que es string
  $stmt->execute();
  $result = $stmt->get_result();

