<?php
require_once(__DIR__ . "/../app/controllers/EditarUsuariosAdmin.php");

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

$cliente = $_SESSION['cliente'] ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_registro.css">
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
        <h2 class="titulo-registro">Formulario de Actualizacion</h2>
        <hr>
        <div class="contenedor-registro">
                <form action="../app/controllers/ActualizarUsuario.php" method="POST">
                <div class="nombre-registro">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" require>
                </div>
                <div class="apellido-registro">
                    <label for="apellido">Apellido: </label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo $cliente['apellido']; ?>" require>
                </div>
                <div class="email-registro">
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email" value="<?php echo $cliente['email']; ?>" require>
                </div>
                <div class="telefono-registro">
                    <label for="telefono">Telefono: </label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>">
                </div>
                <div class="direccion-registro">
                    <label for="direccion">Direccion: </label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo $cliente['direccion']; ?>">
                </div>
                <div class="contrasena-registro">
                    <label for="contrasena">Contrasena: </label>
                    <input type="text" id="contrasena" name="contrasena" value="Clave de acceso" disabled>
                </div>
                <div class="iniciar-registro">
                    <input type="hidden" id="cliente_id" name="cliente_id" value="<?php echo $cliente['cliente_id']; ?>">
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