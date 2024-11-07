<?php
require('./models/User.php');

class AuthController {
    private $db;

    // Constructor

    public function __construct($db) {
        $this->db = $db;
    }

    //metodo Register para registrar un usuario
    public function register($data) {
        try {
            $user = new User($this->db);
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];

            if ($user->register()) {
                return json_encode(['message' => 'Successfully registered user']);
            }
            return json_encode(['message' => 'Error registering user']);
        } catch (\Exception $th) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    //metodo Login para iniciar sesion
    public function login($data) {
        try {
            $user = new User($this->db);
            $user->email = $data['email'];
            $user->password = $data['password'];
            $userData = $user->login();
            if ($userData) {
                // Generar token (simple)
                $token = base64_encode($userData['id']);
                return json_encode(['token' => $token, 'user' => $userData]);
            }
            return json_encode(['message' => 'Invalid credentials']);
        } catch (\Exception $th) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
?>