<?php
class Auth {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=localhost;dbname=db_mig_unificada", "root", "");
    }

    public function verificarCredenciales($usuario) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existeUsuario($usuario) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        return $stmt->fetchColumn() > 0;
    }

    public function registrar($usuario, $clave) {
        $stmt = $this->db->prepare("INSERT INTO usuarios (usuario, clave) VALUES (?, ?)");
        $stmt->execute([$usuario, $clave]);
    }

    public function actualizarClave($usuario, $nueva_clave) {
        $stmt = $this->db->prepare("UPDATE usuarios SET clave = ? WHERE usuario = ?");
        $stmt->execute([$nueva_clave, $usuario]);
    }
}
?>
