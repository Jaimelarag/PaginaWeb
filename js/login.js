// Simulando un inicio de sesión correcto o incorrecto 
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();

    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    if(username === "usuario" && password === "contraseña") {
        document.getElementById('success-message').style.display = 'block';
        setTimeout(function() {
            window.location.href = 'index.html'; // Redirige al index después de unos segundos
        }, 2000);
    } else {
        document.getElementById('error-message').style.display = 'block';
    }
});