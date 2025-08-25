<?php
if (!class_exists('Conexion')) {
    class Conexion {
        public static function conectar() {
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=db_mig_unificada", "root", "");
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conexion;
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
    }
}

