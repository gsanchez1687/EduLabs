<?php
//Se crea la clase Databse para la configuración de la base de datos
class Database {
    private $host = '127.0.0.1';
    private $port = '8889';
    private $db_name = 'edulabs';
    private $username = 'root';
    private $password = 'root';
    public $conn;


    //Se crea la función para la configuración de la base de datos
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
