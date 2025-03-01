<?php
session_start();
?>

<nav>
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="perfil.php">Perfil</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li><a href="usuarios-administracion.php">Usuarios Administración</a></li>
            <li><a href="citas-administracion.php">Citas Administración</a></li>
            <li><a href="noticias-administracion.php">Noticias Administración</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="logout.php">Cerrar sesión</a></li>
        <?php else: ?>
            <li><a href="login.php">Iniciar sesión</a></li>
        <?php endif; ?>
    </ul>
</nav>
