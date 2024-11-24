<?php

require_once (__DIR__ . "/../../config/Config.php");

    class Habitaciones {
        private $conn;

        public function __construct($conn){
            $this->conn=$conn;
        }

        public function obtenerHabitaciones() {
            $sql = "SELECT * FROM habitaciones";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function obtenerHabitacionesBusqueda(){
            $sql = "SELECT * FROM habitaciones WHERE cantidad_habitaciones > 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function obtenerHabitacionesFiltradas($tipo, $precio_min, $precio_max){
            $sql = "SELECT * FROM habitaciones WHERE disponibilidad = 1 AND precio BETWEEN ? AND ?";
            
            if (!empty($tipo)) {
                $sql .= " AND tipo = ?";
            }
            
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($tipo))  {
                $stmt->bind_param('dds', $precio_min, $precio_max, $tipo);
            } else {
                $stmt->bind_param('dd', $precio_min, $precio_max);
            }
            
            $stmt->execute();
            return $stmt->get_result();
        }

        public function reservarHabitacion($id_usuario, $habitacion_id, $fecha_entrada, $fecha_salida, $costo) {
            $stmt = $this->conn->prepare("INSERT INTO reservaciones (cliente_id, habitacion_id, fecha_entrada, fecha_salida, costo) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iissd", $id_usuario, $habitacion_id, $fecha_entrada, $fecha_salida, $costo);
            return $stmt->execute();
        }

        public function disminuirDisponibilidad($habitacion_id){
            $stmt = $this->conn->prepare("UPDATE habitaciones SET cantidad_habitaciones = cantidad_habitaciones - 1 WHERE habitacion_id = ?");
            $stmt->bind_param("i",$habitacion_id);
            return $stmt->execute();
        }

        public function obtenerHabitacionReservada($habitacion_id){
            $stmt = $this->conn->prepare("SELECT * FROM habitaciones WHERE habitacion_id = ?");
            $stmt->bind_param("i", $habitacion_id);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function incrementarDisponibilidad($habitacion_id){
            $stmt = $this->conn->prepare("UPDATE habitaciones SET cantidad_habitaciones = cantidad_habitaciones + 1 WHERE habitacion_id = ?");
            $stmt->bind_param("i", $habitacion_id);
            $stmt->execute();
            return $stmt->get_result();
        }
        
        // En tu clase Habitaciones
        public function obtenerHabitacionPorId($habitacion_id) {
            // Prepara la consulta SQL
            $stmt = $this->conn->prepare("SELECT * FROM habitaciones WHERE habitacion_id = ?");
            $stmt->bind_param("i", $habitacion_id);  // El parámetro es un entero (id)
            $stmt->execute();  // Ejecutar la consulta
            
            // Obtener el resultado
            $resultado = $stmt->get_result();
            
            // Devolver el resultado
            return $resultado;
        }

        public function eliminarHabitacion($habitacion_id) {
            $stmt = $this->conn->prepare("DELETE FROM habitaciones WHERE habitacion_id=?");
            $stmt->bind_param("i",$habitacion_id);
            return $stmt->execute();
        }

        public function actualizarHabitacion($habitacion_id, $nombre, $descripcion, $precio, $disponibilidad, $cantidad_habitaciones, $imagen, $tipo){
            $stmt = $this->conn->prepare("UPDATE habitaciones SET nombre = ?, descripcion = ?, precio = ?, disponibilidad = ?, cantidad_habitaciones = ?, imagen = ?, tipo = ? WHERE habitacion_id = ?");
            $stmt->bind_param("ssdiisss", $nombre, $descripcion, $precio, $disponibilidad, $cantidad_habitaciones, $imagen, $tipo, $habitacion_id);
            return $stmt->execute();
        }

    }

?>