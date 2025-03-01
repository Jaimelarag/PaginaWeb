<?php
include 'conexion.php'; // Archivo con la conexión a la base de datos
session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit();
}

$idUser = $_SESSION['idUser'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agendar'])) {
        $fecha_cita = trim($_POST['fecha_cita']);
        $motivo_cita = trim($_POST['motivo_cita']);

        $stmt = $conn->prepare("INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $idUser, $fecha_cita, $motivo_cita);

        if ($stmt->execute()) {
            echo "<script>alert('Cita agendada correctamente.'); window.location.href='citaciones.php';</script>";
        } else {
            echo "<script>alert('Error al agendar la cita.'); window.location.href='citaciones.php';</script>";
        }

        $stmt->close();
    }

    if (isset($_POST['editar'])) {
        $idCita = $_POST['idCita'];
        $nueva_fecha = trim($_POST['nueva_fecha']);
        $nuevo_motivo = trim($_POST['nuevo_motivo']);

        $stmt = $conn->prepare("UPDATE citas SET fecha_cita = ?, motivo_cita = ? WHERE idCita = ? AND idUser = ?");
        $stmt->bind_param("ssii", $nueva_fecha, $nuevo_motivo, $idCita, $idUser);

        if ($stmt->execute()) {
            echo "<script>alert('Cita modificada correctamente.'); window.location.href='citaciones.php';</script>";
        } else {
            echo "<script>alert('Error al modificar la cita.'); window.location.href='citaciones.php';</script>";
        }

        $stmt->close();
    }

    if (isset($_POST['eliminar'])) {
        $idCita = $_POST['idCita'];

        $stmt = $conn->prepare("DELETE FROM citas WHERE idCita = ? AND idUser = ?");
        $stmt->bind_param("ii", $idCita, $idUser);

        if ($stmt->execute()) {
            echo "<script>alert('Cita eliminada correctamente.'); window.location.href='citaciones.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar la cita.'); window.location.href='citaciones.php';</script>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
