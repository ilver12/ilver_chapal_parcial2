-- Script de inicialización de la base de datos
-- Crea la tabla users y agrega datos de prueba

-- Crear la tabla users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar tres usuarios de prueba
INSERT INTO users (nombre, email) VALUES
    ('Juan Pérez', 'juan.perez@example.com'),
    ('María García', 'maria.garcia@example.com'),
    ('Carlos Rodríguez', 'carlos.rodriguez@example.com');

-- Mostrar mensaje de confirmación
SELECT 'Base de datos inicializada correctamente' AS Status;
