<?php
include('conexao.php');

if(isset($_POST['email']) || isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: painel.php");

        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
        }

    }

}
?>
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
