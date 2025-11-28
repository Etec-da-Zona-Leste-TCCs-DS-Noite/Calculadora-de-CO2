<?php
class Database {
    private $host = "localhost"; // Mude se necessário
    private $db_name = "ecoCalc"; // Nome do seu BD
    private $username = "root"; // Seu usuário do BD
    private $password = ""; // Sua senha do BD
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
