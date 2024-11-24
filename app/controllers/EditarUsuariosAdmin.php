<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../utils/Logger.php');

session_start();
if (!isset($_SESSION['id'])){
    Logger::escribirLogs("Error: Intento de acceso no autorizado sin sesión activa.");
    header("Location:  http://localhost/ProyectoFinal/Proyecto_Hotel/public/Login.php");
    exit();
}

$usuario_controller = new Clientes($conn);
$cliente_id = null;
if (isset($_GET['cliente_id']) && is_numeric($_GET['cliente_id'])) {
    $cliente_id = intval($_GET['cliente_id']);
    try{
        $resultado = $usuario_controller->getDatosClientesID($cliente_id);
        if ($resultado->num_rows > 0) {
            $data = $resultado->fetch_assoc(); // Asume que solo obtienes una habitación
            $_SESSION['cliente'] = $data;
            header('Location: ../../public/EditarUsuariosAdmin.php');
            exit();
        } else {
            Logger::escribirLogs("Error: Parámetros de ID de cliente no proporcionados controller/EditarUsuariosAdmin.php.");
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