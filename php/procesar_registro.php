<?php
include 'conexion.php'; // Archivo con la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar que el correo no esté registrado
    $checkEmail = $conn->prepare("SELECT idUser FROM users_data WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('El correo ya está registrado.'); window.location.href='registro.php';</script>";
        exit();
    }
    
    // Insertar datos en users_data
    $stmt = $conn->prepare("INSERT INTO users_data (nombre, apellidos, email, telefono) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellidos, $email, $telefono);
    
    if ($stmt->execute()) {
        $idUser = $stmt->insert_id;
        
        // Insertar datos en users_login
        $stmtLogin = $conn->prepare("INSERT INTO users_login (idUser, usuario, password, rol) VALUES (?, ?, ?, 'user')");
        $stmtLogin->bind_param("iss", $idUser, $email, $hashed_password);
        
        if ($stmtLogin->execute()) {
            echo "<script>alert('Registro exitoso.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error al crear la cuenta.'); window.location.href='registro.php';</script>";
        }
    } else {
        echo "<script>alert('Error en el registro.'); window.location.href='registro.php';</script>";
    }
    
    $stmt->close();
    $stmtLogin->close();
    $conn->close();
}
?>