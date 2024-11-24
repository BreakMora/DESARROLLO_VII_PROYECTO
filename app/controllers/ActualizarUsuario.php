<?php

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../utils/Logger.php');

session_start();
if (!isset($_SESSION['id'])) {
    Logger::escribirLogs("Error: Intento de acceso no autorizado sin sesión activa.");
    header("Location: http://localhost/ProyectoFinal/Proyecto_Hotel/public/Login.php");
    exit();
}

// Instanciar controlador de clientes
$usuario_controller = new Clientes($conn);

// Validar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Limpiar y validar los datos del formulario
    $cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_VALIDATE_INT);
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
    $direccion = htmlspecialchars(trim($_POST['direccion']));

    // Validar que no haya campos vacíos o inválidos
    if (!$cliente_id || !$nombre || !$apellido || !$email || !$telefono || !$direccion) {
        Logger::escribirLogs("Error: Datos inválidos o campos vacíos al actualizar el cliente.");
        header('Location: ../../public/EditarClienteAdmin.php?error=Datos inválidos');
        exit();
    }

    try {
        // Actualizar los datos del cliente en la base de datos
        $usuario_controller->actualizarUsuario($cliente_id, $nombre, $apellido, $email, $telefono, $direccion);
        Logger::escribirLogs("Cliente con ID $cliente_id actualizado correctamente.");
        header('Location: ../../public/Admin.php?success=Cliente actualizado');
        exit();
    } catch (Exception $e) {
        Logger::escribirLogs("Excepción: Error al actualizar el cliente. Detalles: " . $e->getMessage());
        header('Location: ../../public/EditarClienteAdmin.php?error=No se pudo actualizar');
        exit();
    }
}
