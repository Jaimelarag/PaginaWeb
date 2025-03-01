<?php
include 'db_connection.php'; // Archivo con la conexión a la base de datos

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Buscar usuario en la base de datos
    $stmt = $conn->prepare("SELECT users_login.idUser, users_login.password, users_login.rol, users_data.nombre FROM users_login JOIN users_data ON users_login.idUser = users_data.idUser WHERE users_login.usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verificar contraseña
        if (password_verify($password, $row['password'])) {
            $_SESSION['idUser'] = $row['idUser'];
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $row['rol'];
            $_SESSION['nombre'] = $row['nombre'];
            
            if ($row['rol'] === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: ../index.html");
            }
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.'); window.location.href='login.php';</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!-- Formulario de login (HTML) -->
<form method="POST">
    <label for="username">Nombre de usuario:</label>
    <input type="text" name="username" id="username" required><br>
    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required><br>
    <button type="submit">Iniciar sesión</button>
</form>