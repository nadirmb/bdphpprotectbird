import PajaroImportar from './pajaro'

//Empezaremos a hacer un par de constantes

const canvas = document.getElementById("gameCanvas");
const dibujo = canvas.getContext("2d");

//Tengo que cargar la imagen del avatar por lo cual tengo que extraerlo con una constante


const pajaritoimg = new Image();
pajaritoimg.src = "../img/ProtectBirdJuegoAvatar.png"


let pajaro = PajaroImportar(canvas);

//Creamos las constantes y variables necesarias para los tubos

const tuboAncho = 30;
const huecoentreTubos = 300;
const velocidadTubos = 10;


const tuboimg = new Image();

tuboimg.src = "../img/TuboProtectBird.png"



//Vamos a crear las variables para el score.

let puntuacion = 0;
let inicioTime = 0;  // Esto va a ser para la puntiacion, ya que creo que lo mas facil es ir pillandolo por segundos. ya que no tengo hecho aun los tubos, y eso va a ser lo mas complicado, asi que voy a hacerlo de esta manera.


//ahora vamos a intentar que salga en pantalla el pajaro, para ver si pilla bien la imagen o si tendré que hacer algunos retoques.
function dibujarPajarito(){
    dibujo.clearRect(0, 0, canvas.width, canvas.height);//Aquí limpiamos todo lo que hay en pantalla por si acaso
    dibujo.drawImage(pajaritoimg, 30, pajaro.getAltura(), 90, 80);  //Aqui hacemos que se dibuje el pajaro.



    //Ahora vamos a dibujar el puntuaje en la esquina de arriba a la derecha, intentaremos hacerla a través de segundos.
    dibujo.fillStyle = "White";
    dibujo.font = "bold 40px Arial";
    dibujo.textAlign = "right";
    dibujo.fillText(`Score: ${puntuacion}`, canvas.width - 15, 30);
    }



//function dibujarTubos(){
    //Aquí limpiamos todo lo que hay en pantalla por si acaso
    //dibujo.drawImage(tuboimg, 775, 180, tuboAncho, 105);  //Aqui hacemos que se dibuje el pajaro.
//}



function darScore(){
    if(inicioTime == 0){
        inicioTime = Date.now(); //Aquí lo que hacemos es sacar los numeros en milisegundos, eso va perfecto para sacar los segundos.
    }

    const tiempocontrario= Date.now(); // Hacemos una resta porque date.now saca los milisegundos desde 1970, por lo cual lo mejor es que se resten los dos entre  si y solo se irá actualizando en base a los segundos que pasa, y lo divido entre 1000 para sacarlo cada segundo.
    puntuacion = Math.floor((tiempocontrario - inicioTime) / 1000);
}



function iniciarGame(){
    pajaro.actualizarPajarito();
    dibujarPajarito();//Esto es para iniciar la funcion de dibujar pajaro.
    requestAnimationFrame(iniciarGame); // Esto es para dibujar la animacion en la pantalla, asi que lo que hará será crear la animacion completa del pajaro.
    darScore();
    //dibujarTubos();
}

document.addEventListener("keydown", (event) =>{
    
    if (event.code == "Enter"){//Aqui lo que hacemos es que si se crea el evento del espacio active la funcion del salto.
        iniciarGame(); //Esto es para iniciar el juego
    };

});

document.addEventListener("keydown", (event) =>{
    
    if (event.code == "Space"){//Aqui lo que hacemos es que si se crea el evento del espacio active la funcion del salto.
        pajaro.saltoPajarito();
    };
    if (event.code == "Space"){
        event.preventDefault();//Esto es para que cuando le demos al espacio no se mueva la pagina web a la hora de jugar.
    };

});