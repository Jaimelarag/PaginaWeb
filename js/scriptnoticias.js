document.addEventListener("DOMContentLoaded", function () {
    const contenedor = document.getElementById("contenedor-noticias");

    function cargarNoticias() {
        fetch("./assets/noticias.json")
            .then(response => response.json())
            .then(noticias => {
                contenedor.innerHTML = ""; 
                
                noticias.forEach(noticia => {
                    let noticiaElemento = document.createElement("div");
                    noticiaElemento.classList.add("noticia");
                    noticiaElemento.innerHTML = `<h3>${noticia.titulo}</h3><p>${noticia.contenido}</p>`;
                    contenedor.appendChild(noticiaElemento);
                });
            })
            .catch(error => console.error("Error cargando noticias:", error));
    }

    cargarNoticias();
});