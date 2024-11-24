<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Reservaciones.php');
require_once(__DIR__ . '/../models/Clientes.php');

if(isset($_SESSION['id'])){
    $id_usuario = $_SESSION['id'];
} else {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: ../../public/Login.php");
    // Finaliza el script para evitar que el resto del código se ejecute
    exit();
}

$habitacion_controller = new Habitaciones($conn);
$resultado = $habitacion_controller->obtenerHabitaciones();
$habitaciones = [];

if($resultado->num_rows > 0){
    while($habitacion = $resultado->fetch_assoc()){
        $habitaciones[] = $habitacion;
    }
}

?>