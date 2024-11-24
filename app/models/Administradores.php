<?php

require_once (__DIR__ . "/../../config/Config.php");

class Administradores {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function verificarAdmin($email){
        $stmt = $this->conn->prepare("SELECT email FROM administradores WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        $existe = $stmt->num_rows > 0; // Verifica si hay resultados
        return $existe;
    }

    public function getDatosAdmin($email){
        $sql = "SELECT * FROM administradores WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result();
    }

    /*public function actualizarContrasena($nueva_contraseña_hash) {
        $sql = "UPDATE administradores SET contrasena = ? WHERE admin_id = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nueva_contraseña_hash);
        $stmt->execute();
    }*/
}

?>