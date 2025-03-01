<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include('includes/db_connection.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
    // Recibir los datos del formulario y validarlos
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO users_data (first_name, last_name, email) VALUES (?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $email]);

    $user_id = $conn->lastInsertId();

    $stmt = $conn->prepare("INSERT INTO users_login (user_id, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $username, $password, $role]);

    echo "Usuario creado exitosamente";
}
?>

<!-- Formulario de creación de usuario (HTML) -->
<form method="POST">
    <input type="text" name="first_name" placeholder="Nombre" required><br>
    <input type="text" name="last_name" placeholder="Apellido" required><br>
    <input type="email" name="email" placeholder="Correo electrónico" required><br>
    <input type="text" name="username" placeholder="Nombre de usuario" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <select name="role">
        <option value="user">Usuario</option>
        <option value="admin">Administrador</option>
    </select><br>
    <button type="submit" name="create_user">Crear Usuario</button>
</form>
