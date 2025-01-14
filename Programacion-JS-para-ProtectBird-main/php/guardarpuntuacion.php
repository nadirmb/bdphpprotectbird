<?php
session_start();

// verificamos si el usuario ha iniciado sesion sino le decimos que inice sesion
if (!isset($_SESSION['username'])) {
    echo "Debe iniciar sesión para guardar la puntuación."; // si no hay un usuario en la sesion se mostrara un mensaje 
    exit(); // detenmos el código aquí si no está logueado
}

// verificamos si la petición es POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("El metodo no es permitido."); // si no es una peticion POST se muestra un mensaje de error y termina la ejecuiion
}

// recibimos los datos enviados desde el formulario
$puntuacionNueva = intval($_POST['puntuacion']); // usamos el intval ya que con esto convertimos la puntuación recibida en un número entero y nos asseguramos que los datos se han manejadoo corectament
$username = $_SESSION['username']; // recuperramos el nombre de usuario desde la sesion

// Conectamos a la base de datos. 
    $host = "localhost"; // el servidordonde está la base de datos
    $user = "root"; // el usuario de la base de datos
    $password = ""; // la contraseña 
    $dbname = "protect_bird_db"; // el nombre de la base de datos
    $conn = new mysqli($host, $user, $password, $dbname); // creamos la conexión

    // si no podemos conectarnos mostramos el error y terminamos el script
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error); //mostramos mensaje si hay error al conectarse
    }

// preparamos la consulta para evitar problemas como inyecciones sql donde un usuario con malas intenciones podría intentar ejecutar comandos dañinos en la base de datos.
$stmt = $conn->prepare($query); 
$stmt->bind_param("s", $username); // pasamos el nombre del usuario para buscarlo en la base de datos
$stmt->execute(); // ejecutamos la conuslta
$result = $stmt->get_result(); // sacamos los resultados de la consulta
$data = $result->fetch_assoc(); // converitmos los resultados en un array para trabajar más fácil con ellos

