<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_login.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
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
                    <li><a href="Login.php" class="activo">Iniciar Sesión</a></li>
                    <li><a href="Registro.php">Registrarse</a></li>
                </ul>
            </div>
        </div>
    </header>



    <section>
        <h2 class="titulo-login">Iniciar sesión</h2>
        <div class="contenedor-login">
            <form action="../app/controllers/Procesar_Login.php" method="POST">
                <div class="email-login">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="password-login">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena">
                </div>
                <div class="iniciar-login">
                    <input type="submit" value="Iniciar sesión"></input>
                </div>
            </form>
        </div>

        <div class="contenedor-informacion">
            <div class="recuperar-contrasena">
                <p>¿Olvidaste tu contraseña? <a href="Recuperar_Contraseña.php">Recuperar Contraseña</a></p>
            </div>
            <div class="registro">
                <p>¿No tienes cuenta? <a href="Registro.php">Regístrate</a></p>
            </div>
        </div>
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