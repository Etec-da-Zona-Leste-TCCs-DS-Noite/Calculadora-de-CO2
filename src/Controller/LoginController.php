<?php
session_start();
header('Content-Type: application/json');

// Inclui a classe de conexão (o caminho relativo é importante aqui)
require_once 'Conexão.php'; 

$database = new Database();
$db = $database->getConnection();

// Recebe e decodifica o JSON enviado pelo JavaScript
$data = json_decode(file_get_contents("php://input"));

$response = ['success' => false, 'message' => 'Requisição inválida.'];

if (isset($data->action)) {
    switch ($data->action) {
        case 'register':
            if (isset($data->email) && isset($data->password)) {
                $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
                // Criptografa a senha de forma segura antes de salvar no SQL
                $passwordHash = password_hash($data->password, PASSWORD_DEFAULT); 

                // EDITADO: Usando a tabela 'usuario'
                $query = "INSERT INTO usuario (email, senha) VALUES (:email, :senha)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $passwordHash);

                if ($stmt->execute()) {
                    $response = ['success' => true, 'message' => 'Usuário registrado com sucesso!'];
                } else {
                    $response = ['success' => false, 'message' => 'Erro ao registrar usuário no banco de dados.'];
                }
            }
            break;

        case 'login':
            if (isset($data->email) && isset($data->password)) {
                $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
                // EDITADO: Usando a tabela 'usuario' e selecionando a coluna 'cod'
                $query = "SELECT cod, email, senha FROM usuario WHERE email = :email";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($data->password, $user['senha'])) {
                    // Senha correta! Inicia a sessão PHP
                    $_SESSION["loggedin"] = true;
                    // EDITADO: Usando $user['cod'] para o ID da sessão
                    $_SESSION["id"] = $user['cod']; 
                    $_SESSION["email"] = $user['email'];
                    $response = ['success' => true, 'message' => 'Login efetuado com sucesso! Redirecionando...'];
                } else {
                    $response = ['success' => false, 'message' => 'Email ou senha inválidos.'];
                }
            }
            break;
            
        case 'logout':
            // Finaliza a sessão PHP
            $_SESSION = array();
            session_destroy();
            $response = ['success' => true, 'message' => 'Sessão encerrada.'];
            break;
    }
}

echo json_encode($response);
?>
