<?php
include 'conexion.php'; // Archivo con la conexión a la base de datos
session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit();
}

$idUser = $_SESSION['idUser'];

// Obtener datos del usuario
$stmt = $conn->prepare("SELECT nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo FROM users_data WHERE idUser = ?");
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['actualizar'])) {
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $telefono = trim($_POST['telefono']);
        $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
        $direccion = trim($_POST['direccion']);
        $sexo = trim($_POST['sexo']);

        $stmt = $conn->prepare("UPDATE users_data SET nombre = ?, apellidos = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, sexo = ? WHERE idUser = ?");
        $stmt->bind_param("ssssssi", $nombre, $apellidos, $telefono, $fecha_nacimiento, $direccion, $sexo, $idUser);
        
        if ($stmt->execute()) {
            echo "<script>alert('Perfil actualizado correctamente.'); window.location.href='perfil.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el perfil.'); window.location.href='perfil.php';</script>";
        }
        
        $stmt->close();
    }

    if (isset($_POST['cambiar_password'])) {
        $password_actual = trim($_POST['password_actual']);
        $password_nueva = trim($_POST['password_nueva']);
        $password_confirmar = trim($_POST['password_confirmar']);

        $stmt = $conn->prepare("SELECT password FROM users_login WHERE idUser = ?");
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $stmt->bind_result($password_hash);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password_actual, $password_hash)) {
            if ($password_nueva === $password_confirmar) {
                $password_nueva_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users_login SET password = ? WHERE idUser = ?");
                $stmt->bind_param("si", $password_nueva_hash, $idUser);

                if ($stmt->execute()) {
                    echo "<script>alert('Contraseña cambiada correctamente.'); window.location.href='perfil.php';</script>";
                } else {
                    echo "<script>alert('Error al cambiar la contraseña.'); window.location.href='perfil.php';</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('Las nuevas contraseñas no coinciden.'); window.location.href='perfil.php';</script>";
            }
        } else {
            echo "<script>alert('La contraseña actual es incorrecta.'); window.location.href='perfil.php';</script>";
        }
    }
}

$conn->close();
?>