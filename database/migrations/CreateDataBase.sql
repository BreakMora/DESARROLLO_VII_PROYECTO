CREATE DATABASE proyecto_hotel;

USE proyecto_hotel;

DROP TABLE clientes;
DROP TABLE administradores;
DROP TABLE habitaciones;
DROP TABLE reservaciones;

SELECT * FROM administradores;
SELECT * FROM clientes;
SELECT * FROM habitaciones;
SELECT * FROM reservaciones;

CREATE TABLE administradores (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,           	
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN DEFAULT TRUE,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'administrador') DEFAULT 'administrador'
);

CREATE TABLE clientes (
    cliente_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    direccion VARCHAR(255),                 	
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'administrador') DEFAULT 'cliente'
);

CREATE TABLE habitaciones (
  habitacion_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  disponibilidad BOOLEAN DEFAULT TRUE,
  cantidad_habitaciones TINYINT UNSIGNED DEFAULT 0,
  imagen VARCHAR(255) DEFAULT NULL,
  tipo VARCHAR(50) DEFAULT NULL
);

CREATE TABLE reservaciones (
    reservacion_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    admin_id INT NOT NULL,
    fecha_reservacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_entrada DATE NOT NULL,          
    fecha_salida DATE NOT NULL,           
    costo DECIMAL(10, 2) NOT NULL,        
    FOREIGN KEY (cliente_id) REFERENCES clientes(cliente_id),
    FOREIGN KEY (habitacion_id) REFERENCES habitaciones(habitacion_id)
);

INSERT INTO `habitaciones` (`nombre`, `descripcion`, `precio`, `disponibilidad`, `cantidad_habitaciones`, `imagen`, `tipo`) VALUES
('Habitación Sencilla', 'Habitación ideal para una persona, con una cama individual, baño privado y una pequeña mesa de trabajo.', 50.00, 1, 5, 'habitacion_sencilla.jpg', 'sencilla'),
('Habitación Doble', 'Habitación cómoda para dos personas, con una cama matrimonial, baño privado y vista al mar.', 80.00, 1, 3, 'habitacion_doble.jpg', 'doble'),
('Suite', 'Habitación de lujo con cama king size, baño con jacuzzi, y vistas panorámicas de la ciudad.', 150.00, 1, 2, 'suite.jpg', 'suite'),
('Habitación Familiar', 'Habitación espaciosa con dos camas dobles, ideal para familias, con baño privado y área de juegos para niños.', 120.00, 1, 4, 'habitacion_familiar.jpg', 'familiar');

INSERT INTO `habitaciones` (`nombre`, `descripcion`, `precio`, `disponibilidad`, `cantidad_habitaciones`, `imagen`, `tipo`) VALUES
('Habitación abc', 'Habitación ideal para una a, con una cama b, baño c y una pequeña mesa de d.', 700.00, 1, 10, 'abc.jpg', 'penhouse');


