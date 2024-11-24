<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();
// Incluir el archivo correspondiente según los filtros enviados
if ($_SERVER['REQUEST_METHOD'] === 'GET' && (!empty($_GET['tipo']) || isset($_GET['precio_min']) || isset($_GET['precio_max']))) {
    require_once(__DIR__ . '/../app/controllers/Procesar_Filtros.php');
} else {
    require_once(__DIR__ . '/../app/controllers/Obtener_Habitaciones.php');
}

$rol_usuario = null;
if (isset($_SESSION['rol'])) {
    $rol_usuario = $_SESSION['rol'];
}

// Determina si el botón debe estar habilitado o deshabilitado
$disabled = ($rol_usuario === 'cliente') ? '' : 'disabled'; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Habitaciones</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_busqueda.css">
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
                    <li><a href="Busqueda.php" class="activo">Habitaciones</a></li>
                    <?php if (!empty($rol_usuario)): ?>
                        <?php if ($rol_usuario == 'cliente'): ?>
                            <li><a href="Cliente.php">Reservaciones</a></li>
                        <?php elseif ($rol_usuario == 'administrador'): ?>
                            <li><a href="Admin.php">Administración</a></li>
                        <?php endif; ?>
                        <li><a href="Logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="Login.php">Iniciar Sesión</a></li>
                        <li><a href="Registro.php">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <!-- Formulario de filtros de búsqueda
    <section>
        <a href="Logout.php">Cerrar Sesión</a>
        <a href="cliente.php">Volver</a>
    </section>
    -->

    <section class="contenido">
        <!-- Formulario de filtros de búsqueda -->
        <div class="filtro-busqueda">
            <h2 class="titulo-busqueda">Buscar Habitaciones</h2>
            <div class="contenedor-busqueda">
                <form method="GET" action="Busqueda.php">
                    <div class="tipo-busqueda">
                        <label for="tipo">Tipo de Habitación:</label>
                        <select name="tipo" id="tipo">
                            <option value="">Todos</option>
                            <option value="sencilla" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'sencilla' ? 'selected' : ''; ?>>Sencilla</option>
                            <option value="doble" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'doble' ? 'selected' : ''; ?>>Doble</option>
                            <option value="suite" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'suite' ? 'selected' : ''; ?>>Suite</option>
                            <option value="familiar" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'familiar' ? 'selected' : ''; ?>>Familiar</option>
                        </select>
                    </div>
                    <div class="precio_min-busqueda">
                        <label for="precio_min">Precio Mínimo:</label>
                        <input type="number" name="precio_min" id="precio_min" placeholder="0" min="0" value="<?php echo isset($_GET['precio_min']) ? htmlspecialchars($_GET['precio_min']) : 0; ?>">
                    </div>
                    <div class="precio_max-busqueda">
                        <label for="precio_max">Precio Máximo:</label>
                        <input type="number" name="precio_max" id="precio_max" placeholder="150" min="0" value="<?php echo isset($_GET['precio_max']) ? htmlspecialchars($_GET['precio_max']) : 150; ?>">
                    </div>
                    <div class="iniciar-busqueda">
                        <button type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mostrar habitaciones (todas o filtradas) como cards-->
        <div class="resultado-busqueda">
            <h2 class="titulo-resultado">Catálogo de Habitaciones Disponibles</h2>
            <?php if (count($habitaciones) > 0): ?>
                <div class="contenedor-habitaciones">
                    <?php foreach ($habitaciones as $habitacion): ?>
                        <div class="habitacion">
                            <div class="habitacion-imagen">
                                <?php $imagen = $habitacion['imagen']; ?>
                                <img class="habitacion-img" src="../assets/<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>">
                            </div>
                            <div class="habitacion-nombre">
                                <h3><?php echo htmlspecialchars($habitacion['nombre']); ?></h3>
                            </div>
                            <div class="habitacion-descripcion">
                                <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
                            </div>
                            <div class="habitacion-estado">
                                <p><strong>Estado: </strong><?php echo htmlspecialchars($habitacion['disponibilidad'] ? "Disponible" : "No disponible"); ?></p>
                            </div>
                            <div class="habitacion-precio">
                                <p><strong>Precio por noche: </strong>$<?php echo number_format($habitacion['precio'], 2); ?></p>
                            </div>
                            <div>
                                <p><strong>Tipo: </strong><?php echo ucfirst(htmlspecialchars($habitacion['tipo'])); ?></p>
                            </div>
                            <div class="reservar-busqueda">
                                <form method="POST" action="Confirmar_Reserva.php">
                                    <input type="hidden" name="habitacion_id" value="<?php echo htmlspecialchars($habitacion['habitacion_id']); ?>">
                                    <div class="reservar-buton">
                                        <button class="reservar-btn"  <?php echo $disabled; ?>>Reservar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="mensaje-busqueda">
                    <p>No hay habitaciones disponibles<?php echo isset($_GET['tipo']) || isset($_GET['precio_min']) || isset($_GET['precio_max']) ? ' según los filtros seleccionados' : ''; ?>.</p>
                </div>
            <?php endif; ?>
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