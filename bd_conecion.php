<?php
// datos de la conexion a la base de datos
$host="localhost"; // de momento como solo lo estamos probando lo dejaremos en localhost 
$user="root"; //este es el usuario de la base de datos 
$password"1234"; //contraseña de la base de datos
$dbname = "protect_bird_db" // aqui ponemos el nombre de la base de datos

// conexion con la base de datos
$conn = new mysqli($host, $user, $password, $dbname);