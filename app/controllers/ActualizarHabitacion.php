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

if($_SERVER['REQUEST_METHOD']=='POST'){
    $habitacion_id = filter_input(INPUT_POST, 'habitacion_id', FILTER_VALIDATE_INT);
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $disponibilidad = isset($_POST['disponibilidad']) && $_POST['disponibilidad'] === 'Si' ? 1 : 0;
    $cantidad_habitaciones = filter_input(INPUT_POST, 'cantidad_habitaciones', FILTER_VALIDATE_INT);
    $imagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_URL);
    $tipo = htmlspecialchars(trim($_POST['tipo']));

    if (!$habitacion_id || !$nombre || !$descripcion || $precio === false || !$cantidad_habitaciones) {
        Logger::escribirLogs("Error: Datos inválidos o campos vacíos al actualizar la habitación.");
        header('Location: ../../public/EditarHabitacionAdmin.php');
        exit();
    }

    try{
        $habitacion_controller->actualizarHabitacion($habitacion_id, $nombre, $descripcion, $precio, $disponibilidad, $cantidad_habitaciones, $imagen, $tipo);
        header('Location: ../../public/Admin.php');
        exit();
    } catch (Exception $e){
        Logger::escribirLogs("Excepción: Error al actualizar la habitación " . $e->getMessage());
        header('Location: ../../public/EditarHabitacionAdmin.php');
        exit();
    }
}

?>