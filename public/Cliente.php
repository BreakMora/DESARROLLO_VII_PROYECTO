<?php

// Inicia la sesión para acceder a las variables de sesión
session_start();
require_once(__DIR__ . "/../app/controllers/Obtener_Reservaciones.php");
require_once(__DIR__ . "/../app/utils/Logger.php");

// Verifica si la variable de sesión 'usuario' no está definida, lo que significa que el usuario no ha iniciado sesión
if (!isset($_SESSION['id'])) {
    Logger::escribirLogs("Error: Intento de acceso de negado.");
    header("Location: ../index.php");
    exit();
} 
// Verifica si el rol del usuario es 'cliente' y redirige si es así
if (!isset($_SESSION['rol']) && !$_SESSION['rol']=='cliente' || !$_SESSION['rol']=='administrador') {
    Logger::escribirLogs("Advertencia: El usuario : " . $_SESSION['nombre'] . ", con ID: " . $_SESSION['id'] . ", no tiene permiso para entrar a este archivo.");
    header("Location: ../index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_cliente.css">
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
                    <li><a href="Cliente.php" class="activo">Reservaciones</a></li>
                    <li><a href="Logout.php">Cerrar Sesion</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section class="contenido-perfil">
        <div class="titulo-perfil">
            <h2> Bienvenido, <?php echo htmlspecialchars_decode($_SESSION['nombre']); ?> !</h2>
        </div>
        <!-- Mostrar todas las reservaciones hechas -->
        <div class="sutitulo-perfil">
            <h2>Tus reservaciones</h2>
        </div>
        <?php if (count($habitaciones_reservadas) > 0): ?>
            <div class="habitaciones-container">
                <?php foreach ($habitaciones_reservadas as $habitacion): ?>
                    <div class="habitacion">
                        <div class="habitacion-imagen">
                            <?php $imagen = !empty($habitacion['imagen']) ? htmlspecialchars($habitacion['imagen']) : 'imagen_por_defecto.jpg'; ?>
                            <img class="habitacion-img" src="../assets/<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>">
                        </div>
                        <div class="habitacion-nombre">
                            <h3><?php echo htmlspecialchars($habitacion['nombre']); ?></h3>
                        </div>
                        <div class="habitacion-descripcion">
                            <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
                        </div>
                        <div class="habitacion-tipo">
                            <p><strong>Tipo: </strong><?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></p>
                        </div>
                        <div class="habitacion-precio">
                            <p><strong>Precio por noche: </strong>$<?php echo number_format($habitacion['precio'], 2); ?></p>
                        </div>
                        <div class="habitacion-fecha_entrada">
                            <p><strong>Fecha de entrada: </strong> <?php echo htmlspecialchars($habitacion['fecha_entrada']); ?></p>
                        </div>
                        <div class="habitacion-fecha-salida">
                            <p><strong>Fecha de salida: </strong> <?php echo htmlspecialchars($habitacion['fecha_salida']); ?></p>
                        </div>
                        <div class="habitacion-costo">
                            <p><strong>Costo total: </strong>$<?php echo number_format($habitacion['costo'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div>
                <p>No has reservado habitaciones aún.</p>
            </div>
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