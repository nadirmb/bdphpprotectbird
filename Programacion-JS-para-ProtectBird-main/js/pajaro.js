//por lo que he visto tengo que poner la configuracion del avatar, asi que tendremos q poner la fuerza de salto y esas cosas

export default function PajaroImportar(canvas){

    let pajaritoAltura = canvas.height / 2; //Lo he dividido entre 2 para que empiece en la mitad
    let pajaritoVel = 1; //Pa darle la velocidad, empiezo por cero porque haré una funcion donde vaya pillando velocidad
    const jump = -7; //Para darle lo que tiene que saltar. 
    const gravedad = 0.5; //para hacer la gravedad


    function saltoPajarito(){
        pajaritoVel = jump; //Hacemos esto para ahora crear una funcion donde lo que haremos es si tocamos cierta tecla lo que hará sera hacer que la velocidad del pajaro 
        //sea igual que el salto, practicamente será para que el salto se inicie.
    }
    
    function getAltura() {
        return pajaritoAltura; // Devuelve la altura del pajarito
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
    return{
        actualizarPajarito,
        saltoPajarito,
        getAltura
    }
    

}

