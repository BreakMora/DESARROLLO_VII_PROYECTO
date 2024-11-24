<?php
session_start();
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Habitaciones.php');
require_once(__DIR__ . '/../utils/Logger.php');

if (!isset($_SESSION['id'])){
    Logger::escribirLogs("Error: Intento de acceso no autorizado sin sesión activa.");
    header("Location: ../../public/Login.php");
    exit();
}

$habitacion_controller = new Habitaciones($conn);
// Verificar si se ha pasado un ID de reservación
if (isset($_GET['habitacion_id'])) {
    $habitacion_id = intval($_GET['habitacion_id']);
    // Eliminar la reservación
    try{
        $resultado = $habitacion_controller->eliminarHabitacion($habitacion_id);
        if ($resultado) {
            header('Location: ../../public/Admin.php');
            exit();
        } else {
            Logger::escribirLogs("Error: No se pudo eliminar la habitacion con ID $habitacion_id.");
        }
    } catch (Exception $e){
        Logger::escribirLogs("Excepción: no se pudo eliminar la habitacion " . $e->getMessage());
    }
} else {
    Logger::escribirLogs("Error: Parámetros de ID de habitacion no proporcionados.");
}
?>