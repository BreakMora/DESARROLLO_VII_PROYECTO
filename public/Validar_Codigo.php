<?php
session_start();

// Inicializar el estado de validación
if (!isset($_SESSION['codigo_validado'])) {
    $_SESSION['codigo_validado'] = false;
}

// Verificar si el código de verificación ya está definido en la sesión
if (isset($_SESSION['codigo_verificacion'])) {
    $codigo_enviado = $_SESSION['codigo_verificacion'];
} else {
    // Si no está definido, asignamos un valor null
    $codigo_enviado = null;
}

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigo_verificacion']) && $_POST['codigo_verificacion'] === $codigo_enviado) {
        // El código es correcto, redirigir a la página de cambio de contraseña
        $_SESSION['codigo_validado'] = true;
        header("Location: Cambiar_Contraseña.php");
        exit;
    } else {
        // Si el código es incorrecto, mostrar un mensaje de error
        $_SESSION['error_codigo'] = "El código de verificación es incorrecto.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Código de Verificación</title>
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

    
    <section class="contenedor-validador">
        <h1>Ingresar Código de Verificación</h1>
        <!-- Formulario para ingresar el código de verificación -->
        <?php if (!$_SESSION['codigo_validado']): ?>
            <form action="" method="post">
                <div class="validar-codigo">
                    <label for="codigo_verificacion">Código de Verificación</label><br>
                    <input type="text" name="codigo_verificacion">
                </div>
                <input type="submit" value="Verificar">
            </form>

            <?php
            // Mostrar mensaje de error si el código es incorrecto
            if (isset($_SESSION['error_codigo'])) {
                echo "<p style='color: red;'>{$_SESSION['error_codigo']}</p>";
                unset($_SESSION['error_codigo']);
            }
            ?>

        <?php else: ?>
            <!-- Si el código ya fue validado, redirige a la página de cambio de contraseña -->
            <p>El código de verificación es correcto. Serás redirigido a la página de cambio de contraseña...</p>
            <meta http-equiv="refresh" content="2; url=Cambiar_Contraseña.php">
        <?php endif; ?>
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