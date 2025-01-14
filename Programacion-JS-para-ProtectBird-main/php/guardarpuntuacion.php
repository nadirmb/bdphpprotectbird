<?php
session_start();

// verificamos si el usuario ha iniciado sesion sino le decimos que inice sesion
if (!isset($_SESSION['username'])) {
    echo "Debe iniciar sesión para guardar la puntuación."; // si no hay un usuario en la sesion se mostrara un mensaje 
    exit(); // detenmos el código aquí si no está logueado
}

// verificamos si la petición es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $puntuacion_nueva = intval($_POST['puntuacion']); // usamos el intval ya que con esto convertimos la puntuación recibida en un número entero y nos asseguramos que los datos se han manejadoo corectament
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
$stmt = $conn->prepare("SELECT id FROM jugadores WHERE nombre = ?");
$stmt->bind_param("s", $username); // pasamos el nombre del usuario para buscarlo en la base de datos
$stmt->execute(); // ejecutamos la conuslta
$result = $stmt->get_result(); // sacamos los resultados de la consulta

// aqui estamos revisando si la consulta ha traido algún resultado es decir si encontramos un usuario con ese nombre
if ($result->num_rows > 0) {
    // si encontramos el usuario usamos fetch_assoc() para traer los datos de ese usuario
    $row = $result->fetch_assoc();
    
    // cojemos el id que está en la fila que nos devolvió la consulta y lo guardamos en la variable $id_jugador
    // este id es lo que nos sirve para identificar a ese jugador en la base de datos
    $id_jugador = $row['id'];
    
 // ahora buscamos la puntuación más alta que tiene el jugador
$stmt = $conn->prepare("SELECT MAX(puntuacion) AS max_puntuacion FROM puntuaciones WHERE id_jugador = ?");
// aquí estamos preparando una consulta SQL para obtener la puntuación más alta que tiene un jugador específico en la tabla puntuaciones
// usamos la función MAXpuntuacion que nos da el valor más alto de la columna puntuacion de la base de datos para un jugador

$stmt->bind_param("i", $id_jugador); // le pasamos el id del jugador
// estamos pasando el id del jugador que hemos guardado en la variable $id_jugador a la consulta
// el i significa que vamos a pasar un valor entero

$stmt->execute(); // ejecutamos la consulta
// es cuando el programa va a buscar la puntuación mas alta del jugador en la base de datos

$result = $stmt->get_result(); // obtenemos el resultado de la consulta

$row = $result->fetch_assoc(); // obtenemos los datos y con fetch_assoc() obtenemos una fila del resultado
// esta fila es como un array donde las claves son los nombres de las columnas de la base de datos y los valores son los datos que recuperamos de esas columnas

$max_puntuacion = intval($row['max_puntuacion']); // guardamos la puntuación más alta
// ahora estamos cogiendo el valor de la columna max_puntuacion de la fila que obtuvimos antes y lo guardamos en la variable $max_puntuacion pero antes de guardarlo usamos intval para asegurarnos de que el valor sea un número entero
// esto es importante porque si la base de datos devuelve un valor como un texto o un valor NULL intval lo convertira en un numero entero
// si el valor no se puede convertir intval lo pondra a 0 asin se puede evitar errores más adelante en el código

// comprobamos si la nueva puntuacion es mayor que la actual
if ($puntuacion_nueva > $max_puntuacion) {
   // si el jugador obtiene una nueva puntuación que es mayor que la maxima puntuacion que ya tiene registrada en la base de datos entonces esa nueva puntuación se guardara en la base de datos    
    $stmt = $conn->prepare("INSERT INTO puntuaciones (puntuacion, id_jugador) VALUES (?, ?)"); // preparamos la consulta para insertar los datos
    $stmt->bind_param("ii", $puntuacion_nueva, $id_jugador); //pasamos la nueva puntuacion y el id del jugador y con el ii nos asseguramos que los datos pasados como parametros son enteros

// ejecutamos la consulta para guardar la nueva puntuacion
if ($stmt->execute()) {
    echo "Nueva puntuación guardada:". $puntuacion_nueva; // si se ha guardado correctamente mostramos un mensaje
} else {
     echo "Error al guardar la puntuación: ". $stmt->error; // si ha habidoo un error al guardar mostramos el error
}

// si la nueva puntuacion no es mas alta mostramos un mensaje
} else {
    echo "No se guarda la puntuación porque no supera la puntuación más alta:" . $max_puntuacion;
}

// si no encontramos al usuario mostramos un mensaje de error
} else {
    echo  "Error: usuario no encontrado.";

}
// Cerrar la conexión
$stmt->close();
$conn->close();
} else {
    // Este else es para cuando no se usa el método POST
    echo "Método no permitido.";
}

?>