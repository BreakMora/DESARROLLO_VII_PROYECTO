<?php
session_start();
if (!isset($_SESSION['codigo_validado']) || !$_SESSION['codigo_validado']) {
    header("Location: Validar_Codigo.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_resetcontra.css">
</head>

<body>
    <header class="encabezado">
        <div class="container-navegador">
            <div class="Esquina-izquierda">
                <!-- Logo del sitio -->
                <a href="" class="logo">
                    <img src="../assets/terraza_sol.png" alt="La Terraza del Sol" class="logo-img">
                    <div class="logo-texto">La Terraza del Sol</div>
                </a>
            </div>
            <div class="Esquina-derecha">
                <ul class="barra-navegacion">
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="Busqueda.php">Habitaciones</a></li>
                    <li><a href="Login.php">Iniciar Sesión</a></li>
                    <li><a href="Registro.php">Registrarse</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section class="contenedor-confirmador">
        <!-- Formulario para cambiar la contraseña -->
        <form action="../app/controllers/Cambiar_Contraseña.php" method="post" name="Cambia_Contraseña">
            <div>
                <label for="nueva_contraseña">Nueva Contraseña</label><br>
                <input type="password" name="nueva_contraseña">
            </div>

            <div>
                <label for="confirmar_contraseña">Confirmar Contraseña</label><br>
                <input type="password" name="confirmar_contraseña">
            </div>

            <input type="submit" name="cambiar_contraseña" value="Cambiar Contraseña">
        </form>
    </section>

    <footer class="footer">
        <div class="container-footer">
            <div class="contacto">
                <p>Contacto: <a href="mailto:hotelcecil2024@gmail.com">hotelcecil2024@gmail.com</a></p>
            </div>
            <div class="redes-sociales">
                <p>Síguenos en:</p>
                <ul>
                    <li><a href="https://facebook.com/laterradelsol" target="_blank">Facebook</a></li>
                    <li><a href="https://instagram.com/laterradelsol" target="_blank">Instagram</a></li>
                    <li><a href="https://twitter.com/laterradelsol" target="_blank">Twitter</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 La Terraza del Sol. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>