-- Primero creareoms la base de datos de protect bird --
-- de momento solo estamos probando diferentes soluciones para poder--
-- relacionar bien las tablas entre ellas--
-- primero crearemos la base de datos de protect bird--
Create DATABASE protect_bird_db;
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
    -- Crearemos tambien una tabla para las puntuaciones para que cada vez que haga una nueva puntuacion se guarde --
Create Table puntuaciones (
    id INT PRIMARY KEY,
    puntuacion INT,
    id_jugador INT,
    FOREIGN KEY  (id_jugador) REFERENCES jugadores -- esta seria la relacion que hay entre la tabla de puntuaciones 
    -- y jugadores ya que cada puntuacion tiene que ir relacionada con la tabla de jugadores --
    )
--Hemos pensado en hacer una tabla para la configuracion del juego, como el sonido etc....... --
Create table configuracion(
    id INT PRIMARY KEY;
    sonido BOOLEAN;
    id_jugadordos INT;
    FOREIGN KEY  (id_jugadordos) REFERENCES jugadores -- esta seria otra FK el nombre es diferente para poder dferenciarse entre ellas --
)

-- de momento hay una tabla puntuaciones, configuracio, jugadores (usuarios) nombre correo contraseña 