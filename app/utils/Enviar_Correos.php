<?php

require_once(__DIR__ . '/../../config/Config.php');

class EnviarCorreos{
    private const REMITENTE = "hotelcecil2024@gmail.com";
    private $email_destino;
    private $asunto;
    private $mensaje;

    public function __construct($email_destino, $asunto, $mensaje) {
        $this->setEmailDestino($email_destino);
        $this->asunto=$asunto;
        $this->mensaje=$mensaje;
    }

    public function setEmailDestino($email_destino){
        if(filter_var($email_destino, FILTER_VALIDATE_EMAIL)){
            $this->email_destino=$email_destino;
        } else {
            throw new InvalidArgumentException("El correo electrónico de destino no es válido.");
        }
    }

    public function enviar(){
        $encabezado = "From: " . self::REMITENTE . "\r\n";
        $encabezado .= "Reply-To: " . self::REMITENTE . "\r\n";
        $encabezado .= "Content-Type: text/html; charset=UTF-8\r\n";

        if(mail($this->email_destino,$this->asunto,$this->mensaje, $encabezado)){
            return true;
        } else {
            return false;
        }
    }


}

?>