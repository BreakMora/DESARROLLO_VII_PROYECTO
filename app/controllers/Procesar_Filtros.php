<?php

require_once(__DIR__ . '/../../config/Config.php'); // Incluir conexión a la base de datos
require_once(__DIR__ . '/../models/Habitaciones.php'); // Llama al modelo de habitaciones
require_once(__DIR__ . '/../utils/Logger.php');

$habitaciones = [];

try {
    // Crear instancia del controlador de habitaciones
    $controller = new Habitaciones($conn);

    // Obtener parámetros del formulario
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
    $precio_min = isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : 0;
    $precio_max = isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : 150;

    // Obtener los resultados filtrados
    $resultado = $controller->obtenerHabitacionesFiltradas($tipo, $precio_min, $precio_max);

    // Procesar resultados
    if ($resultado && $resultado->num_rows > 0) {
        while ($habitacion = $resultado->fetch_assoc()) {
            $habitaciones[] = $habitacion;
        }
    } else {
        Logger::escribirLogs("Advertencia: No se encontraron habitaciones según los filtros seleccionados.");
    }
} catch (Exception $e) {
    Logger::escribirLogs("Error: Excepción al intentar obtener las habitaciones con filtros. E: " . $e->getMessage());
    $habitaciones = []; // Asegurar que esté vacío en caso de error
}

// Cerrar la conexión a la base de datos
$conn->close();
?>