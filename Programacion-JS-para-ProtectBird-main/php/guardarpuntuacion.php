<?php
session_start();

// verificamos si el usuario ha iniciado sesion
if (!isset($_SESSION['username'])) {
    exit("Debe iniciar sesión para guardar la puntuación."); // si no hay un usuario en la sesion se mostrara un mensaje y lo termina
}

// verificamos si la petición es POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("El metodo no es permitido."); // si no es una peticion POST se muestra un mensaje de error y termina la ejecuiion
}

// recibimos los datos enviados desde el formulario
$puntuacionNueva = intval($_POST['puntuacion']); // usamos el intval ya que con esto convertimos la puntuación recibida en un número entero y nos asseguramos que los datos se han manejadoo corectament
$username = $_SESSION['username']; // recuperramos el nombre de usuario desde la sesion

// Conectamos a la base de datos
$conn = new mysqli("localhost", "root", "", "protect_bird_db"); // hacemoes la conexion con la base de datos
if ($conn->connect_error) { // comprobamos si hay un error al conectar
    exit("Error de conexión: " . $conn->connect_error); //entonces sii hay error mostramos el mensaje y detenemos la ejecución
}

// hacemos una consulta SQL para obtener el ID del jugador y su puntuación máxima
$query = "
    SELECT j.id, MAX(p.puntuacion) AS max_puntuacion
    FROM jugadores j
    LEFT JOIN puntuaciones p ON j.id = p.id_jugador 
    WHERE j.nombre = ?"; // queremos obtener el ID del jugador y la maximaa puntuación registrada de ese jugador
    // Usamos LEFT JOIN para incluir jugadores incluso si no tienen puntuaciones.

// preparamos la consulta para evitar problemas como inyecciones SQL
$stmt = $conn->prepare($query); 
$stmt->bind_param("s", $username); // pasamos el nombre del usuario para buscarlo en la base de datos
$stmt->execute(); // ejecutamos la conuslta
$result = $stmt->get_result(); // sacamos los resultados de la consulta
$data = $result->fetch_assoc(); // converitmos los resultados en un array para trabajar más fácil con ellos