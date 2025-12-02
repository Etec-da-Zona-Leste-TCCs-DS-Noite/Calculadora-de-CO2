<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método HTTP não permitido. Use POST.']);
    exit;
}

require_once __DIR__ . '/Conexao.php';

try {
    $database = new Conexao();
    $db = $database->getConnection();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco de dados.']);
    exit;
}

$data = json_decode(file_get_contents("php://input"));
if (!is_object($data) || !isset($data->action)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
    exit;
}

$response = ['success' => false, 'message' => 'Requisição inválida.'];

switch ($data->action) {
    case 'register':
        if (isset($data->email, $data->password)) {
            $email = filter_var(trim($data->email), FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                $response = ['success' => false, 'message' => 'Email inválido.'];
                break;
            }

            $password = trim($data->password);
            if (strlen($password) < 6) {
                http_response_code(400);
                $response = ['success' => false, 'message' => 'Senha muito curta (mínimo 6 caracteres).'];
                break;
            }

            try {
                // Verifica se email já existe
                $check = $db->prepare("SELECT cod FROM usuario WHERE email = ?");
                $check->bind_param("s", $email);
                $check->execute();
                $check->store_result();
                
                if ($check->num_rows > 0) {
                    http_response_code(409);
                    $response = ['success' => false, 'message' => 'Email já cadastrado.'];
                    break;
                }

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO usuario (email, senha) VALUES (?, ?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss", $email, $passwordHash);

                if ($stmt->execute()) {
                    http_response_code(201);
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

    case 'login':
        if (isset($data->email, $data->password)) {
            $email = filter_var(trim($data->email), FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                $response = ['success' => false, 'message' => 'Email inválido.'];
                break;
            }

            try {
                $query = "SELECT cod, email, senha FROM usuario WHERE email = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if ($user && password_verify($data->password, $user['senha'])) {
                    session_regenerate_id(true);
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user['cod'];
                    $_SESSION["email"] = $user['email'];

                    http_response_code(200);
                    $response = ['success' => true, 'message' => 'Login efetuado com sucesso!'];
                } else {
                    http_response_code(401);
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
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        http_response_code(200);
        $response = ['success' => true, 'message' => 'Sessão encerrada.'];
        break;

    default:
        http_response_code(400);
        $response = ['success' => false, 'message' => 'Ação desconhecida.'];
        break;
}

echo json_encode($response);
exit;
?>