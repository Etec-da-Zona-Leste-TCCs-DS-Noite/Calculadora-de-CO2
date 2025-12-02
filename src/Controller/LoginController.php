<?php
// Inicia a sessão para permitir login, logout e uso de variáveis de sessão
session_start();

// Define o tipo de retorno como JSON
header('Content-Type: application/json; charset=utf-8');

// Se a requisição for OPTIONS (CORS pré-flight), encerra e retorna OK
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Aceita apenas requisições POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // 405 = Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Método HTTP não permitido. Use POST.']);
    exit;
}

// Importa a classe de conexão com o banco de dados
require_once __DIR__ . '/Conexao.php';

// Tenta conectar ao banco
try {
    $database = new Conexao();
    $db = $database->getConnection();
} catch (Exception $e) {
    // Falha na conexão
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco de dados.']);
    exit;
}

// Lê os dados JSON enviados pelo front-end
$data = json_decode(file_get_contents("php://input"));

// Garante que o JSON é válido e contém "action"
if (!is_object($data) || !isset($data->action)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
    exit;
}

// Resposta padrão inicial
$response = ['success' => false, 'message' => 'Requisição inválida.'];

// -------------------------------------------------------------------
// SWITCH PRINCIPAL: define qual ação executar (register, login, logout)
// -------------------------------------------------------------------
switch ($data->action) {

    // ============================================================
    // ▌ REGISTRAR NOVO USUÁRIO
    // ============================================================
    case 'register':
        // Garante que email e senha foram enviados
        if (isset($data->email, $data->password)) {

            // Valida e sanitiza o email
            $email = filter_var(trim($data->email), FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                $response = ['success' => false, 'message' => 'Email inválido.'];
                break;
            }

            // Valida tamanho mínimo da senha
            $password = trim($data->password);
            if (strlen($password) < 6) {
                http_response_code(400);
                $response = ['success' => false, 'message' => 'Senha muito curta (mínimo 6 caracteres).'];
                break;
            }

            try {
                // Verifica se o email já está cadastrado
                $check = $db->prepare("SELECT cod FROM usuario WHERE email = ?");
                $check->bind_param("s", $email);
                $check->execute();
                $check->store_result();

                // Já existe
                if ($check->num_rows > 0) {
                    http_response_code(409);
                    $response = ['success' => false, 'message' => 'Email já cadastrado.'];
                    break;
                }

                // Criptografa a senha
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Insere o usuário
                $query = "INSERT INTO usuario (email, senha) VALUES (?, ?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss", $email, $passwordHash);

                if ($stmt->execute()) {
                    http_response_code(201); // Criado
                    $response = ['success' => true, 'message' => 'Usuário registrado com sucesso!'];
                } else {
                    http_response_code(500);
                    $response = ['success' => false, 'message' => 'Erro ao registrar usuário.'];
                }

                $stmt->close();
                $check->close();

            } catch (Exception $e) {
                http_response_code(500);
                $response = ['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()];
            }

        } else {
            http_response_code(400);
            $response = ['success' => false, 'message' => 'Dados incompletos.'];
        }
        break;

    // ============================================================
    // ▌ LOGIN DE USUÁRIO
    // ============================================================
    case 'login':
        if (isset($data->email, $data->password)) {

            // Sanitiza e valida email
            $email = filter_var(trim($data->email), FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                $response = ['success' => false, 'message' => 'Email inválido.'];
                break;
            }

            try {
                // Busca usuário no banco
                $query = "SELECT cod, email, senha FROM usuario WHERE email = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                // Verifica senha
                if ($user && password_verify($data->password, $user['senha'])) {

                    // Garante sessão segura
                    session_regenerate_id(true);

                    // Salva dados do usuário na sessão
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user['cod'];
                    $_SESSION["email"] = $user['email'];

                    http_response_code(200);
                    $response = ['success' => true, 'message' => 'Login efetuado com sucesso!'];

                } else {
                    http_response_code(401); // Unauthorized
                    $response = ['success' => false, 'message' => 'Email ou senha inválidos.'];
                }

                $stmt->close();

            } catch (Exception $e) {
                http_response_code(500);
                $response = ['success' => false, 'message' => 'Erro no servidor.'];
            }

        } else {
            http_response_code(400);
            $response = ['success' => false, 'message' => 'Dados incompletos.'];
        }
        break;

    
    case 'logout':
        // Apaga variáveis da sessão
        $_SESSION = [];

        // Remove cookie da sessão, se existir
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '',
                time() - 42000, // força expiração
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destrói a sessão
        session_destroy();

        http_response_code(200);
        $response = ['success' => true, 'message' => 'Sessão encerrada.'];
        break;

    
    default:
        http_response_code(400);
        $response = ['success' => false, 'message' => 'Ação desconhecida.'];
        break;
}

// Retorna JSON final para o front-end
echo json_encode($response);
exit;

?>
