<?php
session_start();
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../utils/Logger.php');

if (!isset($_SESSION['id'])){
    Logger::escribirLogs("Error: Intento de acceso no autorizado sin sesión activa.");
    header("Location: ../../public/Login.php");
    exit();
}

$clientes_controller = new Clientes($conn);
// Verificar si se ha pasado un ID de reservación
if (isset($_GET['cliente_id'])) {
    $cliente_id = intval($_GET['cliente_id']);
    // Eliminar la reservación
    try{
        $resultado = $clientes_controller->eliminarCliente($cliente_id);
        if ($resultado) {
            header('Location: ../../public/Admin.php');
            exit();
        } else {
            Logger::escribirLogs("Error: No se pudo eliminar el cliente con ID $cliente_id.");
        }
    } catch (Exception $e){
        Logger::escribirLogs("Excepción: no se pudo eliminar el cliente " . $e->getMessage());
    }
} else {
    Logger::escribirLogs("Error: Parámetros de ID de cliente no proporcionados.");
}
?>