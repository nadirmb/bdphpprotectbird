<?php
// datos de la conexion a la base de datos
$host="localhost"; //localhoostt
$user="root"; //este es el usuario de la base de datos 
$password""; //contraseña de la base de datos
$dbname = "protect_bird_db" // aqui ponemos el nombre de la base de datos

// conexion con la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

// comprobar que la conexion es correcta
if ($conn→connect_error) {
    die("Error de conexión: ". $conn→connect_error); //esto mostrara un mensaje de error si la conexion falla
} else {
    echo "Conexión exitosa a la base de datos."; // Confirmacio!!!!! de conexión exitosa
}
?>