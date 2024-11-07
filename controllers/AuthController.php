<?php
require('./models/User.php');

class AuthController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($data) {
        $user = new User($this->db);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        if ($user->register()) {
            return json_encode(['message' => 'Usuario registrado correctamente']);
        }
        return json_encode(['message' => 'Error al registrar usuario']);
    }

    public function login($data) {
        $user = new User($this->db);
        $user->email = $data['email'];
        $user->password = $data['password'];
        $userData = $user->login();
        if ($userData) {
            // Generar token (simple)
            $token = base64_encode($userData['id']);
            return json_encode(['token' => $token, 'user' => $userData]);
        }
        return json_encode(['message' => 'Credenciales invalidas']);
    }
}
?>