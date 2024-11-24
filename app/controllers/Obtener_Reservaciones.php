<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Reservaciones.php');
require_once(__DIR__ . '/../utils/Logger.php');

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id'])) {
    $id_usuario = $_SESSION['id'];
} else {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    Logger::escribirLogs("Advertencia: Intento de acceso a reservaciones sin iniciar sesión.");
    header("Location: Login.php");
    exit();
}

$reservacion_controller = new Reservaciones($conn);
$resultado = $reservacion_controller->obtenerReservacionUsuario($id_usuario);
$habitaciones_reservadas = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $habitacion_id = $fila['habitacion_id'];
        $fecha_entrada = $fila['fecha_entrada'];
        $fecha_salida = $fila['fecha_salida'];
        $costo = $fila['costo'];

        // Obtener los detalles de la habitación
        $habitacion_controller = new Habitaciones($conn);
        $habitacion_resultado = $habitacion_controller->obtenerHabitacionReservada($habitacion_id);

        if ($habitacion_resultado->num_rows > 0) {
            $habitacion = $habitacion_resultado->fetch_assoc();
            // Agregar la fecha de la reservación a los detalles de la habitación
            $habitacion['fecha_entrada'] = $fecha_entrada;
            $habitacion['fecha_salida'] = $fecha_salida;
            $habitacion['costo'] = $costo;
            $habitaciones_reservadas[] = $habitacion;
        }
    }
}

?>