<?php

require_once(__DIR__ . '/../app/controllers/Reservar_Habitacion.php');
// Verifica si la variable de sesión 'usuario' no está definida, lo que significa que el usuario no ha iniciado sesión
if (!isset($_SESSION['id'])) {
    Logger::escribirLogs("Error: Intento de acceso de negado.");
    header("Location: ../index.php");
    exit();
} 
// Verifica si el rol del usuario es 'cliente' y redirige si es así
if (!isset($_SESSION['rol']) && !$_SESSION['rol']=='cliente' || !$_SESSION['rol']=='administrador')  {
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
    <title>Confirmar Reserva</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_reservacion.css">
    <script>
        function calcularReserva() {
            const precioNoche = <?php echo json_encode($habitacion['precio']) ?>;
            const fechaEntrada = new Date(document.getElementById('fecha_entrada').value);
            const fechaSalida = new Date(document.getElementById('fecha_salida').value);

            if (fechaEntrada && fechaSalida && fechaEntrada < fechaSalida) {
                // Calcular la diferencia en días
                const numNoches = (fechaSalida - fechaEntrada) / (1000 * 60 * 60 * 24);
                const costoTotal = numNoches * precioNoche;

                document.getElementById('costo_total').textContent = "$" + costoTotal.toFixed(2);
                document.getElementById('costo_total_hidden').value = costoTotal.toFixed(2);
            } else {
                document.getElementById('costo_total').textContent = " ";
            }
        }
    </script>
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
                    <li><a href="Cliente.php">Reservaciones</a></li>
                    <li><a href="Logout.php">Cerrar Sesion</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section>
        <h2>Confirmar Reserva</h2>
        <form method="POST" action="Confirmar_Reserva.php">
            <!-- Tabla con los detalles de la habitación y costo -->
            <table border="1">
                <tr>
                    <td rowspan="7"><img src="../assets/<?php echo htmlspecialchars($habitacion['imagen']); ?>" alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>"></td>
                    <td><strong>Nombre de la Habitación:</strong> <?php echo htmlspecialchars($habitacion['nombre']); ?></td>
                </tr>
                <tr>
                    <td><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacion['descripcion']); ?></td>
                </tr>
                <tr>
                    <td><strong>Precio por noche:</strong> $<?php echo number_format($habitacion['precio'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Tipo:</strong> <?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></td>
                </tr>
                <tr>
                    <td><strong>Fecha de Entrada:</strong> <input type="date" name="fecha_entrada" id="fecha_entrada" required onchange="calcularReserva()"></td>
                </tr>
                <tr>
                    <td><strong>Fecha de Salida:</strong> <input type="date" name="fecha_salida" id="fecha_salida" required onchange="calcularReserva()"></td>
                </tr>
                <tr>
                    <td><strong>Costo Total por la Estancia:</strong> <span id="costo_total"> </span></td>
                </tr>
            </table>

            <!-- Formulario para confirmar reserva -->
             <div class="reservar-habitacion">
                <input type="hidden" name="habitacion_id" value="<?php echo htmlspecialchars($habitacion_id); ?>">
                <input type="hidden" name="costo_total" id="costo_total_hidden">
                <button type="submit" name="confirmar_reserva">Confirmar Reserva</button>
             </div>
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