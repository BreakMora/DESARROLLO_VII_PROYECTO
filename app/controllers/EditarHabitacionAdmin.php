<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Habitaciones.php');
require_once(__DIR__ . '/../utils/Logger.php');

session_start();
if (!isset($_SESSION['id'])){
    Logger::escribirLogs("Error: Intento de acceso no autorizado sin sesión activa.");
    header("Location:  http://localhost/ProyectoFinal/Proyecto_Hotel/public/Login.php");
    exit();
}

$habitacion_controller = new Habitaciones($conn);
$habitacion_id = null;
if (isset($_GET['habitacion_id']) && is_numeric($_GET['habitacion_id'])) {
    $habitacion_id = intval($_GET['habitacion_id']);
    try{
        $resultado = $habitacion_controller->obtenerHabitacionPorId($habitacion_id);
        if ($resultado->num_rows > 0) {
            $data = $resultado->fetch_assoc(); // Asume que solo obtienes una habitación
            $_SESSION['habitacion'] = $data;
            header('Location: ../../public/EditarHabitacionAdmin.php');
            exit();
        } else {
            Logger::escribirLogs("Error: Parámetros de ID de habitacion no proporcionados controller/EditarHabitacion.php.");
            header('Location: ../../public/Admin.php');
            exit();
        }
    } catch (Exception $e){
        Logger::escribirLogs("Excepción: no se pudo obtener los datos de la habitacion " . $e->getMessage());
        header('Location: ../../public/Admin.php');
        exit();
    }
}

?>