-- Primero creareoms la base de datos de protect bird --
-- de momento solo estamos probando diferentes soluciones para poder--
-- relacionar bien las tablas entre ellas--
-- primero crearemos la base de datos de protect bird--
Create DATABSE protect_bird_db;
Use protect_bird_db;

-- Primero la idea seria crear la tabLAa de jugadores para guardar la informacion de cada jugador --
-- jugadores son los que juegan al juego, entonces las relaciones como lo que son las puntuaciones --
-- y la configuracion tendria que ir relacionada con una FK a la tabla de jugadores --
Create Table jugadores (
    id INT PRIMARY KEY,
    nombre VARCHAR(55),
    correo VARCHAR(30), 
    contraseña VARCHAR(40),
    -- hemos pensado en la contraseña ponerla en esta table tambien--
)
