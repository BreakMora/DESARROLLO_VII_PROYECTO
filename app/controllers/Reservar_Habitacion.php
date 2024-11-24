<?php

session_start();
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../models/Habitaciones.php');
require_once(__DIR__ . '/../utils/Enviar_Correos.php');
require_once(__DIR__ . '/../utils/Logger.php');

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['id'])) {
    
    header("Location: ../../public/Login.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$email_usuario = $_SESSION['usuario_email'];

$habitacion_id = isset($_POST['habitacion_id']) ? (int)$_POST['habitacion_id'] : 0;
$costo_total = isset($_POST['costo_total']) ? (float)$_POST['costo_total'] : 0.0;

$controller = new Habitaciones($conn);

// Obtener los detalles de la habitación seleccionada
$habitacion = [];
try {
    $resultado = $controller->obtenerHabitacionPorId($habitacion_id);
    if ($resultado && $resultado->num_rows > 0) {
        $habitacion = $resultado->fetch_assoc();
    } else {
        Logger::escribirLogs("Advertencia: No se encontró la habitación con ID $habitacion_id.");
        header("Location: catalogo_habitaciones.php");
        exit();
    }
} catch (Exception $e) {
    Logger::escribirLogs("Error: Excepción al intentar obtener los detalles de la habitación. E: " . $e->getMessage());
    header("Location: catalogo_habitaciones.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fecha_entrada']) && isset($_POST['fecha_salida'])) {
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];

    // Validar que las fechas sean correctas
    if (strtotime($fecha_entrada) < strtotime($fecha_salida)) {
        // Reservar la habitación
        $resultado_reserva = $controller->reservarHabitacion($id_usuario, $habitacion_id, $fecha_entrada, $fecha_salida,$costo_total);

        if ($resultado_reserva) {
            // Disminuir la cantidad de habitaciones disponibles
            $controller->disminuirDisponibilidad($habitacion_id);

            // Enviar correo de confirmación al usuario
            $asunto = 'Reservación Completada';
            $mensaje = 'Usted ha reservado la habitación ' . $habitacion['nombre'] . '. Con un precio total de: $' . number_format($costo_total, 2) . '.';

            $correo = new EnviarCorreos($email_usuario, $asunto, $mensaje);
            $correo->enviar($correo);

            // Redirigir al usuario a la página de búsqueda
            header('Location: ../../public/Busqueda.php');
            exit();
        } else {
            echo "<p>Error al procesar la reserva. Por favor, intente de nuevo.</p>";
        }
    } else {
        echo "<p>Error: La fecha de salida debe ser posterior a la fecha de entrada.</p>";
    }
}