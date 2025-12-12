-- Script para añadir campos de recuperación de contraseña
-- Ejecutar en la base de datos

ALTER TABLE usuarios 
ADD COLUMN reset_token VARCHAR(64) NULL,
ADD COLUMN reset_token_expires DATETIME NULL,
ADD INDEX idx_reset_token (reset_token);
