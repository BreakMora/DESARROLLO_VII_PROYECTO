<?php

session_start();

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../utils/Enviar_Correos.php');
require_once(__DIR__ . '/../utils/Logger.php');

class AutenticarUsuario {
    private $clientes;

    public function __construct($conn) {
        $this->clientes = new Clientes($conn);
    }

    // Redirección a la página indicada
    public function redireccion($redireccion) {
        header("Location: $redireccion");
        exit;
    }

    // Función para enviar el correo de recuperación
    public function enviarCorreoRecuperacion($email_usuario, $codigo_verificacion) {
        $asunto = 'Recuperación de Contraseña';
        $mensaje = 'Código de recuperación de contraseña: ' . $codigo_verificacion;
        // Crea una instancia de EnviarCorreos
        $correo = new EnviarCorreos($email_usuario, $asunto, $mensaje);
        // Retorna si el envío del correo fue exitoso o no
        return $correo->enviar($correo);
    }

    // Función para verificar el usuario y gestionar el flujo de recuperación
    public function verificarUsuario($email_usuario) {
        $email_usuario = trim($email_usuario);

        // Validación de campos vacíos
        if (empty($email_usuario)) {
            Logger::escribirLogs("Error: Los campos no pueden estar vacíos.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        // Validación de formato de correo
        if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
            Logger::escribirLogs("Error: Formato de correo no válido.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        // Verificar si el usuario existe
        if (!$this->clientes->verificarCliente($email_usuario)) {
            Logger::escribirLogs("Error: El email ingresado no pertenece a ninguna cuenta de cliente registrada.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        // Guardar el correo en la sesión
        $_SESSION['usuario_email'] = $email_usuario;

        // Generar un código de verificación de 6 dígitos
        $codigo_verificacion =  rand(100,999) . rand(100,999);

        // Enviar el correo de recuperación
        if ($this->enviarCorreoRecuperacion($email_usuario, $codigo_verificacion)) {
            Logger::escribirLogs('Correo de recuperación enviado, verifica tu bandeja de entrada');
            $_SESSION['codigo_verificacion'] = $codigo_verificacion; // Guardar el código de verificación en la sesión
        } else {
            Logger::escribirLogs('Error al enviar el correo de recuperación. Inténtalo de nuevo más tarde.');
        }

        // Redirigir a la página de validación de código
        header('Location: ../../public/Validar_Codigo.php');
        exit;
    }
}

// Uso del controlador para manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario_email'])) {
    $controller = new AutenticarUsuario($conn);
    
    // Verificar si la conexión a la base de datos está activa
    if (!isset($conn)) {
        Logger::escribirLogs("Error: Conexión a la base de datos no establecida.");
        header('Location: ../../public/Recuperar_Contraseña.php');
        exit;
    }
    
    // Verificar el usuario
    $controller->verificarUsuario($_POST['usuario_email']);
}
?>
