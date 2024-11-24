<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Reservaciones.php');
require_once(__DIR__ . '/../models/Clientes.php');

if (isset($_SESSION['id'])) {
    $id_usuario = $_SESSION['id'];
} else {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: ../../public/Login.php");
    // Finaliza el script para evitar que el resto del código se ejecute
    exit();
}
$datos_usuario = new Clientes($conn);
$reservacion_controller = new Reservaciones($conn);
$resultado = $reservacion_controller->obtenerReservaciones();
$reservaciones = [];

// Obtener el nombre del cliente (usuario) basado en el id_usuario
$cliente_resultado = $datos_usuario->getNombreCliente($id_usuario);
$nombre_cliente = '';
$apellido_cliente = '';

if ($cliente_resultado->num_rows > 0) {
    $cliente = $cliente_resultado->fetch_assoc();
    $nombre_cliente = $cliente['nombre']; 
    $apellido_cliente = $cliente['apellido'];
}

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $habitacion_id = $fila['habitacion_id'];
        $fecha_reservacion = $fila['fecha_reservacion']; // Obtener la fecha de la reservación
        $reservacion_id = $fila['reservacion_id'];
        $fecha_entrada = $fila['fecha_entrada'];
        $fecha_salida = $fila['fecha_salida'];
        $costo = $fila['costo'];

        // Obtener los detalles de la habitación
        $habitacion_controller = new Habitaciones($conn);
        $datos_habitacion = $habitacion_controller->obtenerHabitacionReservada($habitacion_id);

        if ($datos_habitacion->num_rows > 0) {
            $habitacion = $datos_habitacion->fetch_assoc();
            // Agregar la fecha de la reservación a los detalles de la habitación
            $habitacion['fecha_reservacion'] = $fecha_reservacion;
            $habitacion['reservacion_id'] = $reservacion_id;
            $habitacion['fecha_entrada'] = $fecha_entrada;
            $habitacion['fecha_salida'] = $fecha_salida;
            $habitacion['costo'] = $costo;
            $habitacion['nombre_cliente'] = $nombre_cliente;
            $habitacion['apellido_cliente'] = $apellido_cliente;
            $reservaciones[] = $habitacion;
        }
    }
}

?>