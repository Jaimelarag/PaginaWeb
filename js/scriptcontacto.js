// Inicializa el mapa
var map = L.map('map').setView([40.4173, -3.7038], 13); 

// Cargar el mapa con OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Ubicación de la empresa )
var empresaLatLng = [40.4173, -3.7038]; 
var marker = L.marker(empresaLatLng).addTo(map);
marker.bindPopup("<b>Yesos Hnos. Lara</b><br>Río Del Valle Calle Bueno N:23 Bajo A").openPopup();

// Crear ruta desde la ubicación actual del usuario (usando el servicio OSRM)
function calcularRuta() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var userLatLng = [position.coords.latitude, position.coords.longitude]; // Coordenadas del usuario

            // Crear una ruta desde la ubicación del usuario hasta la empresa
            L.Routing.control({
                waypoints: [
                    L.latLng(userLatLng),  // Ubicación actual del usuario
                    L.latLng(empresaLatLng) // Ubicación de la empresa
                ],
                routeWhileDragging: true
            }).addTo(map);
        });
    } else {
        alert("Geolocalización no soportada en este navegador.");
    }
}

// Calcular la ruta cuando el mapa se carga
calcularRuta();