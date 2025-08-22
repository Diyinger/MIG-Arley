<?php
class Conexion {
    private static $instancias = [];
    private $db;

    private function __construct($bd = "db_mig_unificada") {
        $driver = "mysql";
        $host = "localhost";
        $usuario = "root";
        $contrasena = "";

        try {
            $this->db = new PDO("$driver:host=$host;dbname=$bd", $usuario, $contrasena);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstancia($bd = "db_mig_unificada") {
        if (!isset(self::$instancias[$bd])) {
            self::$instancias[$bd] = new self($bd);
        }
        return self::$instancias[$bd];
    }

    public function getConexion() {
        return $this->db;
    }
}
?>