<?php
require_once __DIR__ . '/../modelos/modelo_reservas/Auth.php';    
class AuthController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Auth();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];

            $admin = $this->modelo->verificarCredenciales($usuario);

            if ($admin && password_verify($clave, $admin['clave'])) {
                $_SESSION['admin'] = $admin['usuario'];
                header('Location: indexD.php?url=dashboard');
                exit;
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas.';
                header('Location: indexD.php');
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: indexD.php');
    }

    public function registro() {
        $mensaje_error = '';
        $mensaje_exito = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario']);
            $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

            if ($this->modelo->existeUsuario($usuario)) {
                $mensaje_error = 'El usuario ya existe.';
            } else {
                $this->modelo->registrar($usuario, $clave);
                $mensaje_exito = 'Administrador registrado correctamente.';
            }
        }

        include 'views/registro.php';
    }

public function recuperar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = trim($_POST['usuario'] ?? '');
        $nueva_clave = trim($_POST['nueva_clave'] ?? '');

        if (empty($usuario) || empty($nueva_clave)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header('Location: index.php?url=olvidar');
            exit;
        }

        require_once 'models/Auth.php';
        $auth = new Auth();

        $existe = $auth->verificarCredenciales($usuario); // usa este en vez de obtenerUsuario()

        if (!$existe) {
            $_SESSION['error'] = "Usuario no encontrado.";
            header('Location: indexD.php?url=olvidar');
            exit;
        }

        $nueva_clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);
        $auth->actualizarClave($usuario, $nueva_clave_hash);

        $_SESSION['exito'] = "Contraseña actualizada correctamente.";
        header('Location: indexD.php');
        exit;
    } else {
        header('Location: indexD.php?url=olvidar');
        exit;
    }
}
}

?>
