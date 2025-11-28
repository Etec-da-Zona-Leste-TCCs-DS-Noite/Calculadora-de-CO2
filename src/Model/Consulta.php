<?php
require_once 'Conexão.php';

class UsuarioModel {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConn();
    }

    // CREATE (Criar Usuário) - Sem o nome
    public function criarUsuario($email, $senha) {
        $sql = "INSERT INTO usuarios (email, senha) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        // Execute com os parâmetros para prevenir SQL Injection
        return $stmt->execute([$email, $senha]);
    }

    // READ (Listar Todos os Usuários)
    public function listarUsuarios() {
        $sql = "SELECT * FROM usuarios ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // READ (Buscar Usuário por ID)
    public function buscarUsuario($id) {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // UPDATE (Atualizar Usuário) - Sem o nome
    public function atualizarUsuario($id, $email) {
        $sql = "UPDATE usuarios SET email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$email, $id]);
    }

    // DELETE (Deletar Usuário)
    public function deletarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
