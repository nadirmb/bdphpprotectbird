<?php
// datos de la conexion a la base de datos
$host="localhost"; //localhoostt
$user="root"; //este es el usuario de la base de datos 
$password=""; //contraseña de la base de datos
$dbname = "protect_bird_db"; // aqui ponemos el nombre de la base de datos

// conexion con la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

// comprobar que la conexion es correcta
if ($conn->connect_error) {
    die("Error de conexión: ". $conn→connect_error); //esto mostrara un mensaje de error si la conexion falla
} else {
    echo "Conexión exitosa a la base de datos."; // Confirmacio!!!!! de conexión exitosa
}
//tendremos que verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recoger los datos enviados desde el formulario
    $user = $_POST['username']; // nombre de usuario
    $email = $_POST['email']; // correo electrónico
    $pass = $_POST['password']; // contraseña
    $confirm_pass = $_POST['confirm_password']; // esto sera la confirmacion de la contraseña
    
// verificar si las contraseñas coinciden
if ($pass != $confirm_pass) {
    echo "Las contraseñas no coinciden. Por favor, intentalo de nuevo.";
    exit(); // Detener el script si las contraseñas no coinciden
}
// Encriptar la contraseña para mayor seguridad
$pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

//consulta para insertar datos en la tabla jugadores
$stmt = $conn->prepare("INSERT INTO jugadores (nombre, correo, contraseña) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $email, $pass_hashed);

// Ejecutar la consulta y verificar si todo salio bien
if ($stmt->execute()) {
    echo "Se ha registrado correctamente!!!"; // Mensaje de confirmación de registro
} else {
    echo "Error: " . $stmt->error; // Mostrar mensaje de error si algo falla
}
//Cerrar la consulta
$stmt->close();

//Cerrar la conexión con la base de datos
$conn->close();
?>