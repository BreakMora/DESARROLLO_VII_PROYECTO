<?php
session_start();

$rol_usuario = null;
if (isset($_SESSION['rol'])) {
    $rol_usuario = $_SESSION['rol'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Terraza del Sol</title>
    <link rel="stylesheet" href="assets/menu_inicio.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>

<body>
    <section class="banner">
        <video autoplay loop muted>
            <source src="assets/banner.mp4" type="video/mp4">
        </video>
    </section>

    <header class="encabezado">
        <div class="container-navegador">
            <div class="Esquina-izquierda">
                <!-- Logo del sitio -->
                <a href="" class="logo">
                    <img src="assets/terraza_sol.png" alt="La Terraza del Sol" class="logo-img">
                    <div class="logo-texto">La Terraza del Sol</div>
                </a>
            </div>
            <div class="Esquina-derecha">
                <ul class="barra-navegacion">
                    <li><a href="index.php" class="activo">Inicio</a></li>
                    <li><a href="public/Busqueda.php">Habitaciones</a></li>
                    <?php if (!empty($rol_usuario)): ?>
                        <?php if ($rol_usuario == 'cliente'): ?>
                            <li><a href="public/Cliente.php">Reservaciones</a></li>
                        <?php elseif ($rol_usuario == 'administrador'): ?>
                            <li><a href="public/Admin.php">Administración</a></li>
                        <?php endif; ?>
                        <li><a href="public/Logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="public/Login.php">Iniciar Sesión</a></li>
                        <li><a href="public/Registro.php">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <!-- Sección de Bienvenida -->
    <section class="bienvenida">
        <h1>Bienvenido a La Terraza del Sol</h1>
        <p>Tu lugar ideal para relajarte, disfrutar y crear recuerdos inolvidables. ¡Descubre el paraíso que tenemos preparado para ti!</p>
    </section>

    <!-- Novedades -->
    <section class="novedades">
        <h2>Novedades</h2>
        <div class="novedades-contenedor">
            <article class="novedad">
                <h3>Descuento del 20% en Reservas</h3>
                <p>Reserva antes del 30 de noviembre y obtén un descuento especial en tu estancia.</p>
            </article>
            <article class="novedad">
                <h3>¡Nueva Piscina Infinita!</h3>
                <p>Descubre nuestra nueva piscina infinita con vista al mar, ¡ya abierta para todos nuestros huéspedes!</p>
            </article>
        </div>
    </section>

    <!-- Llamado a la acción -->
    <section class="cta">
        <h2>¿Listo para tus vacaciones?</h2>
        <p>Encuentra la habitación perfecta para tu estancia en La Terraza del Sol.</p>
        <a href="public/Busqueda.php" class="boton-reservar">Reservar Ahora</a>
    </section>

    <!-- Servicios Destacados -->
    <section class="servicios">
        <h2>Servicios Destacados</h2>
        <div class="servicios-contenedor">
            <div class="servicio">
                <img src="assets/spa.jpg" alt="Spa">
                <h3>Spa</h3>
                <p>Relájate con nuestros masajes y tratamientos exclusivos.</p>
            </div>
            <div class="servicio">
                <img src="assets/restaurante.jpg" alt="Restaurante">
                <h3>Restaurante</h3>
                <p>Disfruta de los mejores platos locales e internacionales.</p>
            </div>
            <div class="servicio">
                <img src="assets/actividades.jpg" alt="Actividades">
                <h3>Actividades</h3>
                <p>Explora nuestras excursiones y actividades al aire libre.</p>
            </div>
        </div>
    </section>

    <!-- Opiniones -->
    <section class="opiniones">
        <h2>Lo que dicen nuestros clientes</h2>
        <blockquote>"Un lugar mágico para relajarse y disfrutar en familia. ¡Volveremos pronto!" - Ana G.</blockquote>
        <blockquote>"La mejor experiencia de mi vida. Servicio impecable y vistas increíbles." - Carlos M.</blockquote>
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