
// IMAGEN QUE VA CAMBIANDO: EL EFECTO

document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.imagen-rotativa');
    let imageninicial = 0;

    function rotarimagen() {
        images[imageninicial].classList.remove('active');
        imageninicial = (imageninicial + 1) % images.length;
        images[imageninicial].classList.add('active');
    }

    // Activar la primera imagen
    images[0].classList.add('active');

    // Cambiar imagen cada 10 segundos
    setInterval(rotarimagen, 6000);
});          