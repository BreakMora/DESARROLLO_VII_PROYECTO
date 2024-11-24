<?php

require_once (__DIR__ . "/../../config/Config.php");

    class Clientes {
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        //Verificar si el usuario existe en la base de datos
        public function verificarCliente($email){
            $stmt = $this->conn->prepare("SELECT email FROM clientes WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            
            $existe = $stmt->num_rows > 0; // Verifica si hay resultados
            return $existe;
        }

        //Actualizar la contraseña del usuario
        public function actualizarContrasena($email, $nueva_contrasena) {
            $stmt = $this->conn->prepare("UPDATE clientes SET contrasena = ? WHERE email = ?");
            $stmt->bind_param("ss", $nueva_contrasena, $email);
            $stmt->execute();
        
            return $stmt->affected_rows > 0;
        }

        //Guardar usuario en la base de datos
        public function guardarUsuario($data_usuario){
            if(!$this->verificarCliente($data_usuario['email'])){
                $stmt = $this->conn->prepare("INSERT INTO clientes (nombre, apellido, email, telefono, direccion, contrasena) 
                                            VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", 
                    $data_usuario['nombre'], 
                    $data_usuario['apellido'], 
                    $data_usuario['email'], 
                    $data_usuario['telefono'], 
                    $data_usuario['direccion'], 
                    $data_usuario['contrasena']);
                    
                return $stmt->execute();
            }
            return false;
        }

        public function getDatosClientesEmail($email){
            $sql = "SELECT * FROM clientes WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getNombreCliente($id){
            $sql = "SELECT nombre,apellido FROM clientes WHERE cliente_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getDatosClientes(){
            $sql = "SELECT * FROM clientes";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function eliminarCliente($cliente_id) {
            $stmt = $this->conn->prepare("DELETE FROM clientes WHERE cliente_id=?");
            $stmt->bind_param("i",$cliente_id);
            return $stmt->execute();
        }

        public function getDatosClientesID($cliente_id){
            $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE cliente_id=?");
            $stmt->bind_param("i",$cliente_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado;
        }

        public function actualizarUsuario($cliente_id, $nombre, $apellido, $email, $telefono, $direccion){
            $stmt = $this->conn->prepare("UPDATE clientes SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ? WHERE cliente_id = ?");
            $stmt->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $direccion, $cliente_id);
            return $stmt->execute();
        }
    }
?>