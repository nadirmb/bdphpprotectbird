-- Primero creareoms la base de datos de protect bird --
-- de momento solo estamos probando diferentes soluciones para poder--
-- relacionar bien las tablas entre ellas--
-- primero crearemos la base de datos de protect bird--
Create DATABASE IF NOT EXISTS protect_bird_db;
Use protect_bird_db;

-- Primero la idea seria crear la tabLAa de jugadores para guardar la informacion de cada jugador --
-- jugadores son los que juegan al juego, entonces las relaciones como lo que son las puntuaciones --
-- y la configuracion tendria que ir relacionada con una FK a la tabla de jugadores --
Create Table jugadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(55) NOT NULL,
    correo VARCHAR(30)UNIQUE NOT NULL, 
    contraseña VARCHAR(40)NOT NULL,
    -- hemos pensado en la contraseña ponerla en esta table tambien--
    )
    -- Crearemos tambien una tabla para las puntuaciones para que cada vez que haga una nueva puntuacion se guarde --
Create Table puntuaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    puntuacion INT NOT NULL,
    id_jugador INT NOT NULL,
    FOREIGN KEY (id_jugador) REFERENCES jugadores(id) ON DELETE CASCADE  -- esta seria la relacion que hay entre la tabla de puntuaciones 
    -- y jugadores ya que cada puntuacion tiene que ir relacionada con la tabla de jugadores --
    )
--Hemos pensado en hacer una tabla para la configuracion del juego, como el sonido etc....... --
Create table configuracion(
    id INT PRIMARY KEY,
    sonido BOOLEAN,
    id_jugadordos INT,
    FOREIGN KEY  (id_jugadordos) REFERENCES jugadores -- esta seria otra FK el nombre es diferente para poder dferenciarse entre ellas --
)

-- de momento hay una tabla puntuaciones, configuracion, jugadores nombre correo contraseña 
-- Nos gustaria hacer indices para mejorar el rendimiento y que las busqueadas sean mas rapidas--
--indice para que la busqueda por correo sea aun mas rapida
CREATE UNIQUE INDEX idx_correo ON jugadores(correo);

-- indice para mejorar consultas por jugador en puntuaciones
CREATE INDEX idx_puntuaciones_jugador ON puntuaciones(id_jugadordos);

--indice para búsquedas rapidas en configuracion por el jugador
CREATE INDEX idx_configuracion_jugador ON configuracion(id_jugadordos);