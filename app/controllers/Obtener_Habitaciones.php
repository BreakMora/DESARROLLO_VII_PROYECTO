<?php

require_once(__DIR__ . '/../../config/Config.php'); // Incluir conexión a la base de datos
require_once(__DIR__ . '/../models/Habitaciones.php'); // Llama al modelo de habitaciones
require_once(__DIR__ . '/../utils/Logger.php');


$habitaciones = [];

try {
    // Crear instancia del controlador de habitaciones
    $controller = new Habitaciones($conn);
    // Obtener todas las habitaciones
    $resultado = $controller->obtenerHabitacionesBusqueda();

    // Procesar resultados
    if ($resultado && $resultado->num_rows > 0) {
        while ($habitacion = $resultado->fetch_assoc()) {
            $habitaciones[] = $habitacion;
        }
    } else {
        Logger::escribirLogs("Advertencia: No se encontraron habitaciones disponibles.");
    }
} catch (Exception $e) {
    Logger::escribirLogs("Error: Excepción al intentar obtener las habitaciones. E: " . $e->getMessage());
    $habitaciones = []; // Asegurar que esté vacío en caso de error
}

// Cerrar la conexión a la base de datos
$conn->close();
?>