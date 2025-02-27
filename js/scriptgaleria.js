document.addEventListener("DOMContentLoaded", function () {
    const contenedorGaleria = document.getElementById("contenedor-galeria");
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");

    // Array de imágenes
    const imagenes = [
        { src: "../images/img1.jpg", titulo: "Paisaje Montañoso" },
        { src: "../images/img2.jpg", titulo: "Atardecer en la Playa" },
        { src: "../images/img3.jpg", titulo: "Bosque Misterioso" },
        { src: "../images/img4.jpg", titulo: "Ciudad Nocturna" },
        { src: "../images/img5.jpg", titulo: "Lago Refrescante" },
        { src: "../images/img6.jpg", titulo: "Paisaje Montañoso" },
        { src: "../images/img7.jpg", titulo: "Atardecer en la Playa" },
        { src: "../images/img8.jpg", titulo: "Bosque Misterioso" },
        { src: "../images/img9.jpg", titulo: "Ciudad Nocturna" },
    ];

    let currentIndex = 0; // Índice de la imagen actual

    // Función para mostrar las imágenes
    function mostrarImagenes() {
        contenedorGaleria.innerHTML = ""; // Limpiar el contenedor antes de agregar nuevas imágenes

        // Crear las imágenes en base al índice
        imagenes.forEach((imagen, index) => {
            if (index === currentIndex) {
                let img = document.createElement("img");
                img.src = imagen.src;
                img.alt = imagen.titulo;
                img.classList.add("imagen-galeria");
                contenedorGaleria.appendChild(img);
            }
        });
    }

    // Función para mover a la siguiente imagen
    function siguienteImagen() {
        currentIndex = (currentIndex + 1) % imagenes.length;
        mostrarImagenes();
    }

    // Función para mover a la imagen anterior
    function imagenAnterior() {
        currentIndex = (currentIndex - 1 + imagenes.length) % imagenes.length;
        mostrarImagenes();
    }

    // Asignar eventos a las flechas
    prevButton.addEventListener("click", imagenAnterior);
    nextButton.addEventListener("click", siguienteImagen);

    // Inicializar la galería
    mostrarImagenes();
});