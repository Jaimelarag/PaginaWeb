<?php
// Incluir el archivo de conexión a la base de datos
include('db_connection.php');

// Suponemos que ya se ha establecido la conexión a la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validaciones
    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Verificar si el correo electrónico ya está registrado
    $stmt = $conn->prepare("SELECT * FROM users_data WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "El correo electrónico ya está registrado.";
        exit;
    }

    // Verificar si el nombre de usuario ya está tomado
    $stmt = $conn->prepare("SELECT * FROM users_login WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "El nombre de usuario ya está en uso.";
        exit;
    }

    // Insertar los datos personales
    $stmt = $conn->prepare("INSERT INTO users_data (first_name, last_name, email, phone, address) VALUES (:first_name, :last_name, :email, :phone, :address)");
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->execute();
    $user_id = $conn->lastInsertId();
    // Encriptar la contraseña utilizando password_hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);


    // Insertar datos de inicio de sesión
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users_login (user_id, username, password) VALUES (:user_id, :username, :password)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_hash);
    $stmt->execute();

    // Mensaje de confirmación y redirección
    echo "Registro exitoso. Redirigiendo al login...";
    header("Location: /login");
    exit;
}
?>
