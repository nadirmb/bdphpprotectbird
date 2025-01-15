//Empezaremos a hacer un par de constantes

const canvas = document.getElementById("gameCanvas");
const dibujo = canvas.getContext("2d");

//Tengo que cargar la imagen del avatar por lo cual tengo que extraerlo con una constante


const pajaritoimg = new Image();
pajaritoimg.src = "../img/ProtectBirdJuegoAvatar.png"

//por lo que he visto tengo que poner la configuracion del avatar, asi que tendremos q poner la fuerza de salto y esas cosas

let pajaritoAltura = canvas.height / 2; //Lo he dividido entre 2 para que empiece en la mitad
let pajaritoVel = 1; //Pa darle la velocidad, empiezo por cero porque haré una funcion donde vaya pillando velocidad
const jump = -7; //Para darle lo que tiene que saltar. 
const gravedad = 0.4; //para hacer la gravedad


//Vamos a crear las variables para el score.

let puntuacion = 0;
let inicioTime = 0;  // Esto va a ser para la puntiacion, ya que creo que lo mas facil es ir pillandolo por segundos. ya que no tengo hecho aun los tubos, y eso va a ser lo mas complicado, asi que voy a hacerlo de esta manera.


//vamos a hacer las constantes de los tubos:
const tuboAbajo = new Image();
tuboAbajo.src = "../img/TuboProtectBird.png"

const tuboArriba = new Image();
tuboArriba.src = "../img/TuboFlappyBirdReverso.png"

const anchoTubo = 70;
const espacioTubo = 250;
const velocidadTubo = 3;
const tubos = [];

//Vamos a poner musica, por lo cual haré una constante de la musica y la pondremos en bucle.

const musicaFondo = new Audio("../musica/musicaAngry.mp3");
musicaFondo.loop = true; // Para repetir la musica en bucle.


//ahora vamos a intentar que salga en pantalla el pajaro, para ver si pilla bien la imagen o si tendré que hacer algunos retoques.
function dibujarPajarito(){
    dibujo.clearRect(0, 0, canvas.width, canvas.height);//Aquí limpiamos todo lo que hay en pantalla por si acaso
    dibujo.drawImage(pajaritoimg, 30, pajaritoAltura, 90, 80);  //Aqui hacemos que se dibuje el pajaro.



    //Ahora vamos a dibujar el puntuaje en la esquina de arriba a la derecha, intentaremos hacerla a través de segundos.
    dibujo.fillStyle = "White";
    dibujo.font = "bold 40px Arial";
    dibujo.textAlign = "right";
    dibujo.fillText(`Score: ${puntuacion}`, canvas.width - 15, 30);
    }

function saltoPajarito(){
    pajaritoVel = jump; //Hacemos esto para ahora crear una funcion donde lo que haremos es si tocamos cierta tecla lo que hará sera hacer que la velocidad del pajaro 
    //sea igual que el salto, practicamente será para que el salto se inicie.
}




function generarTubos(){
    if (!tubos.length || tubos[tubos.length - 1].x < canvas.width - 550) {  //En este apartado hacemos que si no hay ningun tubo en el array tubos o no hay ningun tubo a 300 px del borde que haga la condicion
        const alturaAleatoria = Math.random() * (canvas.height - espacioTubo - 100) + 50; //Aqui hacemos la constante para darle la altura aleatoria a los tubos.
        tubos.push({ x: canvas.width -300, y: alturaAleatoria }); //Aqui lo que hacemos es añadir un nuevo tubo dentro del array.
    }

    tubos.forEach((tubo, index) => { //Aqui recorremos cada tubo
        tubo.x -= velocidadTubo; //hacemos que se muevan los tubos hacia la izquierda mirando la velocidad.
        if (tubo.x + anchoTubo < 0) tubos.splice(index, 1); // Miramos si el tubo ha salido de la pantalla, y si es asi se borra.
});

}
function dibujarTubos() {
    for (let i = 0; i < tubos.length; i++) { //recorremos todo el array de tubos.
        dibujo.drawImage(tuboArriba, tubos[i].x, 0, anchoTubo, tubos[i].y); //Aqui dibujamos el tubo de arriba.
        dibujo.drawImage(tuboAbajo, tubos[i].x, tubos[i].y + espacioTubo, anchoTubo, canvas.height - (tubos[i].y + espacioTubo));//Aqui dibujamos el tubo de abajo.
    }
}



function actualizarPajarito(){
    pajaritoVel += gravedad; //Aqui hacemos que la velocidad del pajaro vaya aumentando por la gravedad
    pajaritoAltura+= pajaritoVel; // Aquí hacemos que la altura cambie gracias a la velocidad del pajaro


    if (pajaritoAltura > canvas.height - 70){ // Aqui lo que hago es comparar la altura del pajaro con la del canvas
        pajaritoAltura = canvas.height - 75;//Aqui lo igualo para que no baje de la altura del canvas -75
    }

    if (pajaritoAltura < 0){
        pajaritoAltura = 0;
    }
}


function darScore(){
    if(inicioTime == 0){
        inicioTime = Date.now(); //Aquí lo que hacemos es sacar los numeros en milisegundos, eso va perfecto para sacar los segundos.
    }

    const tiempocontrario= Date.now(); // Hacemos una resta porque date.now saca los milisegundos desde 1970, por lo cual lo mejor es que se resten los dos entre  si y solo se irá actualizando en base a los segundos que pasa, y lo divido entre 1000 para sacarlo cada segundo.
    puntuacion = Math.floor((tiempocontrario - inicioTime) / 1000);
}

//Vamos a hacer las colisiones de los tubos.

function tuboColisiones() {
    for (let i = 0; i < tubos.length; i++) {
        const tubo = tubos[i];

        // Para detectar la colision horizontal
        const colisionHorizontal = 30 + 90 > tubo.x && 30 < tubo.x + anchoTubo;

        // Para detectar la colision del tubo de arriba
        const colisionSuperior = pajaritoAltura < tubo.y;

        // Para detectar la colision del tubo de abajo
        const colisionInferior = pajaritoAltura + 80 > tubo.y + espacioTubo;

        
        if (colisionHorizontal && (colisionSuperior || colisionInferior)) {
            // Para mandar la puntuacion al servidor con un post
            fetch('https://localhost/Programacion-JS-para-ProtectBird-main/php/guardarpuntuacion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' //El tipo de datos que se manda urlencoded como clave=valor por ejemplo puntuacion=100
                    },
                    body: `puntuacion=${puntuacion}`  //Enviar la puntuación con la variable para que el servidor la reciba
                    })
                    .then(response => {
                        // Comprobamos si el servidor responde bien
                        if (!response.ok) {
                            throw new Error('error al guardar la puntuacion'); // mostramos que hay un error si algo falla
                            }
                            return response.text(); // devuelve la respuesta del servidor
                            })
                            .then(data => {
                                console.log('puntuacion guardada:', data); // imprimimos en consola para verificar
                                })
                                .catch(error => {
                                    console.error('hubo un problema con la solicitud:', error); // muestra el error en caso de fallo
                                    })
                                    .finally(() => {
                                        // siempre mostramos el mensaje de game over despues
                                        Swal.fire({
                                            title: '¡Game Over!',
                                            text: 'Tu puntuaje en este intento es: ' + puntuacion + '. Dale al botón de "Jugar" si quieres volver a intentarlo ;D',
                                            icon: 'error',
                                            confirmButtonText: '¡OK!'
                                        }).then(() => {
                                            window.location.reload(); // Recarga la página después de cerrar la alerta
                                            });
                                        });
                                            reiniciarJuego();
                                        }
                                    }
                                }

function iniciarGame(){
    document.querySelector('.botoninicio').style.display = 'none';
    musicaFondo.play();
    dibujarPajarito();//Esto es para iniciar la funcion de dibujar pajaro.
    actualizarPajarito();
    tuboColisiones();
    generarTubos();
    dibujarTubos();
    requestAnimationFrame(iniciarGame); // Esto es para dibujar la animacion en la pantalla, asi que lo que hará será crear la animacion completa del pajaro.
    darScore();
}




function reiniciarJuego() {
    // Reiniciamos las variables del juego
    dibujo.clearRect(0, 0, canvas.width, canvas.height);
    pajaritoAltura = canvas.height / 2;
    pajaritoVel = 1;
    puntuacion = 0;
    inicioTime = 0;
    tubos.length = 0; // Vaciamos el array de tubos
    velocidadTubo = 3; // reiniciamos la velocidad de los tubos

    iniciarGame();
}



document.addEventListener("keydown", (event) =>{
    
    if (event.code == "Space"){//Aqui lo que hacemos es que si se crea el evento del espacio active la funcion del salto.
        saltoPajarito();
    };

});

document.addEventListener("click", (event) =>{
    
    if (event.code == "click"){//Aqui lo que hacemos es que si se crea el evento del espacio active la funcion del salto.
        saltoPajarito();
    };

});

document.addEventListener("keydown", (event) =>{
    
    if (event.code == "Space"){
        event.preventDefault();//Esto es para que cuando le demos al espacio no se mueva la pagina web a la hora de jugar.
    };

});
