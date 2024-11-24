<?php
require_once(__DIR__ . "/../app/controllers/EditarHabitacionAdmin.php");

// Verifica si la variable de sesión 'usuario' no está definida, lo que significa que el usuario no ha iniciado sesión
if (!isset($_SESSION['id'])) {
    Logger::escribirLogs("Error: Intento de acceso de negado.");
    header("Location: ../index.php");
    exit();
} 
// Verifica si el rol del usuario es 'cliente' y redirige si es así
if (isset($_SESSION['rol']) && $_SESSION['rol']=='cliente') {
    Logger::escribirLogs("Advertencia: El usuario : " . $_SESSION['nombre'] . ", con ID: " . $_SESSION['id'] . ", no tiene permiso para entrar a este archivo.");
    header("Location: ../index.php");
    exit();
} else {
    // Si el rol no está definido como 'cliente', se registra una advertencia en los logs
    Logger::escribirLogs("Acceso: administrador " . $_SESSION['nombre'] . ".");
}

$habitacion = $_SESSION['habitacion'] ?? [];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Habitacion</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_actualizacion.css">
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
                    <li><a href="Admin.php">Administracion</a></li>
                    <li><a href="Logout.php">Cerrar Sesion</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section>
        <h2 class="titulo-datos">Formulario de Actualizacion</h2>
        <div class="contenedor-datos">
            <form action="../app/controllers/ActualizarHabitacion.php" method="POST">
                <div class="nombre-datos">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $habitacion['nombre']; ?>" require>
                </div>
                <div class="descripcion-datos">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" id="descripcion" name="descripcion" value="<?php echo $habitacion['descripcion']; ?>" require>
                </div>
                <div class="precio-datos">
                    <label for="precio">Precio: </label>
                    <input type="number" id="precio" name="precio" value="<?php echo $habitacion['precio']; ?>" require>
                </div>
                <div class="disponibilidad-datos">
                    <label for="disponibilidad">Disponibilidad: </label>
                    <input type="text" id="disponibilidad" name="disponibilidad" value="<?php echo $habitacion['disponibilidad'] == 1 ? 'Si' : 'No'; ?>" require>
                </div>
                <div class="cantidad_habitaciones-datos">
                    <label for="cantidad_habitaciones">Cantidad habitaciones: </label>
                    <input type="number" id="cantidad_habitaciones" name="cantidad_habitaciones" value="<?php echo $habitacion['cantidad_habitaciones']; ?>" require>
                </div>
                <div class="imagen-datos">
                    <label for="imagen">Imagen: </label>
                    <input type="text" id="imagen" name="imagen" value="<?php echo $habitacion['imagen']; ?>" require>
                </div>
                <div class="tipo-datos">
                    <label for="tipo">Tipo: </label>
                    <input type="text" id="tipo" name="tipo" value="<?php echo $habitacion['tipo']; ?>" require>
                </div>
                <div class="actualizar-datos">
                    <input type="hidden" id="habitacion_id" name="habitacion_id" value="<?php echo $habitacion['habitacion_id']; ?>">
                    <button type="submit">Actualizar</button>
                </div>
            </form>
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