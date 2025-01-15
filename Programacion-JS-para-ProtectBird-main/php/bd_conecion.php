<?php
// datos de la conexión a la base de datos
$host = "localhost"; //localhoostt
$user = "root"; //este es el usuario de la base de datos 
$password = ""; //contraseña de la base de datos
$dbname = "protect_bird_db"; // aqui ponemos el nombre de la base de datos

// conexion con la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

// comprobar que la conexion es correcta
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error); //esto mostrara un mensaje de error si la conexion falla
} else {
    echo "Conexión exitosa a la base de datos."; // Confirmacio!!!!! de conexión exitosa
}

//tendremos que verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos enviados desde el formulario
    $user = $_POST['username']; //  nombre de usuario
    $email = $_POST['email']; //  correo electrónico
    $pass = $_POST['password']; // contraseña
    $confirm_pass = $_POST['confirm_password']; // esto sera la confirmacion de la contraseña

// verifcar si las contraseñas coinciden
if ($pass != $confirm_pass) {
        echo "Las contraseñas no coinciden. Por favor, intentalo de nuevo.";
        exit(); // Detener el script si las contraseñas no coinciden
    }

// encriptar la contraseña para mayor seguridad
    $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

// revisamos si el correo ya esta registrado en la base de datos
$check_email = $conn->prepare("SELECT id FROM jugadores WHERE correo = ?");

// le decimos que use el correo que dio el usuario en la consulta
$check_email->bind_param("s", $email);

// ejecutamos la consulta para buscar en la base de datos
$check_email->execute();

// obtenemos el resultado para ver si la base de datos encontro algo
$result = $check_email->get_result();

// si se encuentra algun resultado significa que el correo ya existe
if ($result->num_rows > 0) {
    // mostramos un mensaje diciendo que el correo ya esta en uso
    echo "El correo ya está registrado. Por favor, utiliza otro.";
    // detenemos el codigo para que no siga intentando registrar
    exit();
}

//consulta para insertar datos en la tabla jugadores
    $stmt = $conn->prepare("INSERT INTO jugadores (nombre, correo, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $pass_hashed); 
    
 
// Ejecutar la consulta y verificar si todo salio bien
    if ($stmt->execute()) {
        echo "Se ha registrado correctamente!!!"; // Mensaje de confirmación de registro
    } else {
        echo "Error: " . $stmt->error; // Mostrar mensaje de error si algo falla
    }
    header("Location:https://localhost/Programacion-JS-para-ProtectBird-main/html/iniciarsesion.html");
    
    
//Cerrar la consulta
    $stmt->close();
}

//Cerrar la conexión con la base de datos
$conn->close();
?>
