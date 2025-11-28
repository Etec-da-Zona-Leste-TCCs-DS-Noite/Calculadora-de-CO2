<?php

class Conexao {
    private $host = 'localhost';
    private $user = 'root';
    private $password = 'ryan140609'; // DEIXE VAZIO se não tiver senha
    private $database = 'login';
    private $connection;

    public function __construct() {
        try {
            $this->connection = new mysqli(
                $this->host,
                $this->user,
                $this->password,
                $this->database
            );

            if ($this->connection->connect_error) {
                throw new Exception("Erro na conexão: " . $this->connection->connect_error);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>