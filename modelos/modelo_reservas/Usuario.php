<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=localhost;dbname=reservas_admin", "root", "");
    }

    public function verificarLogin($usuario, $clave) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && password_verify($clave, $user['clave']);
    }
}
?>