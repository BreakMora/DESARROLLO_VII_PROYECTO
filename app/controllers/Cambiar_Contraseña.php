<?php

session_start();

require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../utils/Logger.php');

class CambiarContrasena {
    private $clientes;

    public function __construct($conn) {
        $this->clientes = new Clientes($conn);
    }

    // Redirigir a la URL con el mensaje de error
    public function redireccion($redireccion) {
        header("Location: $redireccion");
        exit;
    }

    public function validarCampos($nueva_contraseña, $confirmar_contraseña){
        if (empty($nueva_contraseña) || empty($confirmar_contraseña)) {
            Logger::escribirLogs("Advertencia: Uno de los campos de contraseña está vacío.");
            $this->redireccion("../../public/Cambiar_Contraseña.php");
        }
    }

    // Validar las contraseñas y proceder a cambiarla si son correctas
    public function validarNuevaContraseña($nueva_contraseña, $confirmar_contraseña) {
        $nueva_contraseña = trim($nueva_contraseña);
        $confirmar_contraseña = trim($confirmar_contraseña);

        $this->validarCampos($nueva_contraseña, $confirmar_contraseña);

        if ($nueva_contraseña === $confirmar_contraseña) {
            $this->cambiarContrasena($nueva_contraseña);
        } else {
            Logger::escribirLogs("Error: Las contraseñas ingresadas no coinciden. Verifica e intenta nuevamente.");
            $this->redireccion("../../public/Cambiar_Contraseña.php");
        }
    }

    // Cambiar la contraseña en la base de datos
    public function cambiarContrasena($nueva_contraseña) {
        if (!isset($_SESSION['usuario_email'])) {
            Logger::escribirLogs("Error: No se pudo recuperar el correo electrónico del usuario. Sesión expirada o no autenticado.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }

        $email_usuario = $_SESSION['usuario_email'];

        // Aplicar password_hash a la nueva contraseña para asegurarla
        $nueva_contraseña_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

        if ($this->clientes->actualizarContrasena($email_usuario, $nueva_contraseña_hash)) {
            Logger::escribirLogs("Éxito: La contraseña se ha cambiado correctamente para el usuario con correo $email_usuario.");
            $this->redireccion("../../public/Login.php");
        } else {
            Logger::escribirLogs("Error: No se pudo actualizar la contraseña para el usuario con correo $email_usuario. Inténtalo de nuevo más tarde.");
            $this->redireccion("../../public/Recuperar_Contraseña.php");
        }
    }
}

// Uso del controlador para manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nueva_contraseña']) && isset($_POST['confirmar_contraseña'])) {
    // Asegurarse de que la conexión a la base de datos ($conn) esté definida
    if (isset($conn)) {
        $controller = new CambiarContrasena($conn);
        $controller->validarNuevaContraseña($_POST['nueva_contraseña'], $_POST['confirmar_contraseña']);
    } else {
        Logger::escribirLogs('Error: No se pudo establecer conexión con la base de datos. Acción no completada.');
        header('Location: ../../public/Recuperar_Contraseña.php');
        exit;
    }
}

?>
