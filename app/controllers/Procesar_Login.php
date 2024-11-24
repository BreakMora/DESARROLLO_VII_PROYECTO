<?php

session_start(); // Iniciar sesión

// Conexión a la base de datos
require_once(__DIR__ . '/../../config/Config.php');
require_once(__DIR__ . '/../models/Clientes.php');
require_once(__DIR__ . '/../models/Administradores.php');
require_once(__DIR__ . '/../utils/Logger.php');

class Login {
    private $clientes;
    private $administradores;

    public function __construct($conn) {
        $this->clientes = new Clientes($conn);
        $this->administradores = new Administradores($conn);
    }

    // Redirigir a la URL con el mensaje de error
    public function redireccion($redireccion) {
        header("Location: $redireccion");
        exit;
    }

    public function validarCampos($iniciarSesion){
        foreach ($iniciarSesion as $dato => $campo) {
            if (empty($campo)) {
                Logger::escribirLogs("Error: El campo '$dato' vacío.");
                $this->redireccion("../../public/Login.php");
            }
        }
    }

    public function identificarUsuario($email_usuario) {
        if($this->administradores->verificarAdmin($email_usuario)){
            return true;
        } elseif ($this->clientes->verificarCliente($email_usuario)) {
            return false;
        } else {
            Logger::escribirLogs("Error: Correo '$email_usuario' no registrado.");
            $this->redireccion("../../public/Registro.php");
        }
    }

    public function iniciarSesion($iniciarSesion){
        $this->validarCampos($iniciarSesion);
        $usuario = $this->identificarUsuario($iniciarSesion['email']);

        if($usuario){
            $datos = $this->administradores->getDatosAdmin($iniciarSesion['email']);
        } else {
            $datos = $this->clientes->getDatosClientesEmail($iniciarSesion['email']);
        }
        
        if($datos->num_rows > 0){
            $datos_usuario = $datos->fetch_assoc();

            if(password_verify($iniciarSesion['contrasena'], $datos_usuario['contrasena'])){
                $_SESSION['id'] = ($usuario) ? $datos_usuario['admin_id'] : $datos_usuario['cliente_id'];
                $_SESSION['rol'] = $datos_usuario['rol'];
                $_SESSION['nombre'] = $datos_usuario['nombre'];
                $_SESSION['usuario_email'] = $datos_usuario['email'];
                Logger::escribirLogs("Inicio de sesión exitoso para: " . $datos_usuario['email']);
                $this->redireccion("../../index.php");
            } else {
                Logger::escribirLogs("Error: Contraseña incorrecta para el email: " . $iniciarSesion['email']);
                $this->redireccion("../../public/Login.php");
            }

        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new Login($conn);
    // Obtener los datos del formulario
    $iniciar_sesion = [
        'email' => trim($_POST['email']),
        'contrasena' => trim($_POST['contrasena'])
    ];

    if(!isset($conn)){
        Logger::escribirLogs('Error de conexión con la base de datos.');
        header('Location: ../../public/Login.php');
        exit;
    }
    
    // Iniciar Sesion
    $controller->iniciarSesion($iniciar_sesion);
}
?>
