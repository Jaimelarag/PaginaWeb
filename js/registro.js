document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("form").addEventListener("submit", function(event) {
        let nombre = document.querySelector("input[name='nombre']").value.trim();
        let apellidos = document.querySelector("input[name='apellidos']").value.trim();
        let email = document.querySelector("input[name='email']").value.trim();
        let telefono = document.querySelector("input[name='telefono']").value.trim();
        let password = document.querySelector("input[name='password']").value.trim();
        
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let telefonoPattern = /^\d{9,15}$/;
        
        if (nombre === "" || apellidos === "" || email === "" || telefono === "" || password === "") {
            alert("Todos los campos obligatorios deben estar completos.");
            event.preventDefault();
            return;
        }
        
        if (!emailPattern.test(email)) {
            alert("Por favor, introduce un email válido.");
            event.preventDefault();
            return;
        }
        
        if (!telefonoPattern.test(telefono)) {
            alert("El teléfono debe contener entre 9 y 15 dígitos.");
            event.preventDefault();
            return;
        }
        
        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres.");
            event.preventDefault();
            return;
        }
    });
});