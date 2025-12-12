-- Estructura de tabla usuarios para el sistema de autenticación
-- Ejecutar este script en tu base de datos MySQL

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NULL COMMENT 'NULL para usuarios que solo usan Google Sign-In',
    google_id VARCHAR(255) NULL UNIQUE COMMENT 'ID único de Google para OAuth',
    avatar VARCHAR(500) NULL COMMENT 'URL de la imagen de perfil',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_google_id (google_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
