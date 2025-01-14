<?php
session_start(); 

// comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
   // Conectamos a la base de datos. 
   $host = "localhost"; // el servidordonde está la base de datos
   $user = "root"; // el usuario de la base de datos
   $password = ""; // la contraseña 
   $dbname = "protect_bird_db"; // el nombre de la base de datos
   $conn = new mysqli($host, $user, $password, $dbname); // creamos la conexión
    
    // creamos la conexión con la base de datos
    $conn = new mysqli($host, $db_user, $db_pass, $dbname);
    
    // comprobar si la conexión ha sido correcta
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error); // Termina el script si hay un error de conexión
    
}

// consultar si el nombre de usuario existe en la base de datos
  $stmt = $conn->prepare("SELECT * FROM jugadores WHERE nombre = ?");
  $stmt->bind_param("s", $user); // s es para decir que es string
  $stmt->execute();
  $result = $stmt->get_result(); // obtener los resultados de la consulta

  if ($result->num_rows > 0) {  // comprobamos si el resultado de una consulta a la base de datos contiene al menos una fila es decir, si hay datos que coincidan con algunos de la consulta.
    $row = $result->fetch_assoc(); // obtener los datos del usuario desde la base de datos

    if (password_verify($pass, $row['contraseña'])) { // comprobamos si la contraseña que se ha puesto coincide con la guarada
        $_SESSION['username'] = $user; // guarda el nombre de usuario en la sesión para identificar al usuario
        $_SESSION['id_jugador'] = $row['id']; // guradar el ID del jugador para usarlo más tarde

        header("Location:https://localhost/Programacion-JS-para-ProtectBird-main/game/game.html"); // Redirigir al usuario al juego
    } else {
        echo "Contraseña incorrecta."; // si la contraseña es incorrecta, mostrar un mensaje de error
    }
} else {
    echo "El usuario no existe."; // si no se ecuentra al usuario en la base de datos, mostrara un mensaje de error

}
$stmt->close(); 
$conn->close();
}
?>

