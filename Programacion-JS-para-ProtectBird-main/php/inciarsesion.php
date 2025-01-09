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

  if ($result->num_rows > 0) { // comprbamos si el usuario existe en la base de datos
    $row = $result->fetch_assoc(); // obtnemos los datos del usuario desde la base de datos
    if (password_verify($pass, $row['contraseña'])) { // comprobar si la contraseña que se ha puesto coincide con la guarada
        $_SESSION['username'] = $user; // guarda el nombre de usuario en la sesión para identificar al usuario
        header("Location: paginared.php"); // Redirige al usuario a la página paginared.php(es la pagina que se redigira) después de iniciar sesion
    } else {
        echo "Contraseña incorrecta."; 
    }
} else {
    echo "El usuario no existe."; 
}
$stmt->close(); 
$conn->close();
}
?>

