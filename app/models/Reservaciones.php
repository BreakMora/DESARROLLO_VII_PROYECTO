<?php

require_once (__DIR__ . "/../../config/Config.php");
require 'Clientes.php';
require 'Habitaciones.php';

    class Reservaciones{
        private $conn;

        public function __construct($conn){
            $this->conn=$conn;
        }

        public function obtenerReservacionUsuario($id_usuario){
            $stmt = $this->conn->prepare("SELECT * FROM reservaciones WHERE cliente_id = ?");
            $stmt->bind_param("i",$id_usuario);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function obtenerReservaciones(){
            $stmt = $this->conn->prepare("SELECT * FROM reservaciones");
            $stmt->execute();
            return $stmt->get_result();
        }

        public function eliminarReservacion($reservacion_id) {
            $stmt = $this->conn->prepare("DELETE FROM reservaciones WHERE reservacion_id=?");
            $stmt->bind_param("i",$reservacion_id);
            return $stmt->execute();
        }
    }

?>