<?php
class Conexao {
    private static $host = 'localhost';
    private static $dbname = 'ecoCalc'; // Substitua pelo nome do seu DB
    private static $user = 'root'; // Geralmente 'root' para localhost
    private static $pass = ''; // Geralmente vazio para localhost
    private static $instance = null;

    public static function getConn() {
        if (self::$instance === null) {
            try {
                // DSN (Data Source Name)
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4";
                self::$instance = new PDO($dsn, self::$user, self::$pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Define o fetch mode padrão para ARRAY (opcional, pode ser OBJ tbm)
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Em ambiente de produção, registre o erro em um log, não exiba na tela
                die("Erro na conexão com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
