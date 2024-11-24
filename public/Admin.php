<?php

// Inicia la sesión para acceder a las variables de sesión
session_start();
require_once(__DIR__ . "/../app/controllers/ObtenerReservacionesAdmin.php");
require_once(__DIR__ . "/../app/controllers/ObtenerHabitacionesAdmin.php");
require_once(__DIR__ . "/../app/controllers/ObtenerUsuariosAdmin.php");
require_once(__DIR__ . "/../app/utils/Logger.php");

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
    Logger::escribirLogs("Inicio de sesion: por administrador " . $_SESSION['nombre'] . ".");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link rel="stylesheet" href="../assets/menu_inicio.css">
    <link rel="stylesheet" href="../assets/menu_admin.css">
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
                    <li><a href="Admin.php" class="activo">Administracion</a></li>
                    <li><a href="Logout.php">Cerrar Sesion</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section class="contenedor-datos">
        <h2>
            Bienvenido, <?php echo htmlspecialchars_decode($_SESSION['nombre']); ?> !
        </h2>

        <div role="tablist">
            <button role="tab" aria-selected="true" aria-controls="reservaciones" id="tab-reservaciones">Reservaciones</button>
            <button role="tab" aria-selected="false" aria-controls="habitaciones" id="tab-habitaciones">Habitaciones</button>
            <button role="tab" aria-selected="false" aria-controls="usuarios" id="tab-usuarios">Usuarios</button>
        </div>

        <!-- Mostrar todas las reservaciones hechas -->
        <div role="tabpanel" id="reservaciones" aria-labelledby="tab-reservaciones">
            <h2>Reservaciones</h2>
            <?php if (count($reservaciones) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio por noche</th>
                            <th>Costo Total</th>
                            <th>Tipo</th>
                            <th>Hecha por</th>
                            <th>Fecha de la reservación</th>
                            <th>Fecha de Entrada</th>
                            <th>Fecha de Salida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservaciones as $reservacion): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reservacion['reservacion_id']); ?></td>
                                <td>
                                    <?php
                                    // Verificar si la imagen existe o tiene un valor
                                    $imagen = !empty($reservacion['imagen']) ? htmlspecialchars($reservacion['imagen']) : 'imagen_por_defecto.jpg';
                                    ?>
                                    <img src="../assets/<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($reservacion['nombre']); ?>" class="habitacion-img" style="width: 100px; height: auto;">
                                </td>
                                <td><?php echo htmlspecialchars($reservacion['nombre']); ?></td>
                                <td>$<?php echo number_format($reservacion['precio'], 2); ?></td>
                                <td>$<?php echo htmlspecialchars($reservacion['costo']); ?></td>
                                <td><?php echo ucfirst(htmlspecialchars($reservacion['tipo'])); ?></td>
                                <td><?php echo htmlspecialchars($reservacion['nombre_cliente']) . " " . htmlspecialchars($reservacion['apellido_cliente']); ?></td>
                                <td><?php echo htmlspecialchars($reservacion['fecha_reservacion']); ?></td>
                                <td><?php echo htmlspecialchars($reservacion['fecha_entrada']); ?></td>
                                <td><?php echo htmlspecialchars($reservacion['fecha_salida']); ?></td>
                                <td class="acciones">
                                    <button class="boton eliminar" onclick="if(confirm('¿Estás seguro de que deseas eliminar esta reservación?')) location.href='../app/controllers/EliminarReservacionAdmin.php?id=<?php echo $reservacion['reservacion_id']; ?>&habitacion_id=<?php echo $reservacion['habitacion_id']; ?>'">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Actualmente no hay reservado ninguna habitacion aún.</p>
            <?php endif; ?>
        </div>

        <!-- Mostrar todas las habitaciones disponibles o no -->
        <div role="tabpanel" id="habitaciones" aria-labelledby="tab-habitaciones" hidden>
            <h2>Habitaciones</h2>
            <?php if (count($habitaciones) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio por noche</th>
                            <th>Disponibilidad</th>
                            <th>Cantidad de Habitaciones</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($habitaciones as $habitacion): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($habitacion['habitacion_id']); ?></td>
                                <td>
                                    <?php
                                    // Verificar si la imagen existe o tiene un valor
                                    $imagen = !empty($habitacion['imagen']) ? htmlspecialchars($habitacion['imagen']) : 'imagen_por_defecto.jpg';
                                    ?>
                                    <img src="../assets/<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($habitacion['nombre']); ?>" class="habitacion-img" style="width: 100px; height: auto;">
                                </td>
                                <td><?php echo htmlspecialchars($habitacion['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($habitacion['descripcion']); ?></td>
                                <td>$<?php echo number_format($habitacion['precio'], 2); ?></td>
                                <td><?php echo $habitacion['disponibilidad'] == 1 ? 'Si' : 'No'; ?></td>
                                <td><?php echo htmlspecialchars($habitacion['cantidad_habitaciones']); ?></td>
                                <td><?php echo htmlspecialchars($habitacion['tipo']); ?></td>
                                <td class="acciones">
                                    <button class="boton editar" onclick="if(confirm('¿Estás seguro de que deseas editar esta habitación?')) location.href='../app/controllers/EditarHabitacionAdmin.php?habitacion_id=<?php echo $habitacion['habitacion_id']; ?>';">Editar</button>
                                    <button class="boton eliminar" onclick="if(confirm('¿Estás seguro de que deseas eliminar esta habitación?')) location.href='../app/controllers/EliminarHabitacionAdmin.php?habitacion_id=<?php echo $habitacion['habitacion_id']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Actualmente no hay reservado ninguna habitacion aún.</p>
            <?php endif; ?>
        </div>
            
        <!-- Mostrar todos los usuarios registrados -->
        <div role="tabpanel" id="usuarios" aria-labelledby="tab-usuarios" hidden>
            <h2>Usuarios</h2>
            <?php if (count($usuarios) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellid</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['cliente_id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo ($usuario['telefono']); ?></td>
                                <td><?php echo ($usuario['direccion']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                                <td class="acciones">
                                    <button class="boton editar" onclick="if(confirm('¿Estás seguro de que deseas editar este cliente?')) location.href='../app/controllers/EditarUsuariosAdmin.php?cliente_id=<?php echo $usuario['cliente_id']; ?>'">Editar</button>
                                    <button class="boton eliminar" onclick="if(confirm('¿Estás seguro de que deseas eliminar este cliente?')) location.href='../app/controllers/EliminarUsuariosAdmin.php?cliente_id=<?php echo $usuario['cliente_id']; ?>'">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Actualmente no hay reservado ninguna habitacion aún.</p>
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

    <script>
        const tabs = document.querySelectorAll('[role="tab"]');
        const panels = document.querySelectorAll('[role="tabpanel"]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Desactivar todas las pestañas
                tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
                panels.forEach(p => p.hidden = true);

                // Activar la pestaña y contenido correspondiente
                tab.setAttribute('aria-selected', 'true');
                document.getElementById(tab.getAttribute('aria-controls')).hidden = false;
            });
        });
    </script>
</body>