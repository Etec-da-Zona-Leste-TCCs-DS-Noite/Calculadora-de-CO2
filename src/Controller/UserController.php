<?php
require_once '../Model/Consulta.php';

$usuarioModel = new UsuarioModel();

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : 'list');

switch ($action) {
    case 'create':
        if (isset($_POST['email']) && isset($_POST['senha'])) {
            $usuarioModel->criarUsuario($_POST['email'], $_POST['senha']);
            // Redireciona para o novo ponto de entrada HTML
            header('Location: ../View/first.html?status=created');
            exit();
        }
        break;
    
    case 'delete':
        if (isset($_GET['id'])) {
            $usuarioModel->deletarUsuario($_GET['id']);
            // Redireciona para o novo ponto de entrada HTML
            header('Location: ../View/first.html?status=deleted');
            exit();
        }
        break;

    // Ação 'list' agora apenas busca os dados e pode ser chamada via AJAX ou incluir um template
    case 'list':
    default:
        $usuarios = $usuarioModel->listarUsuarios();
        
        // Vamos gerar o HTML da tabela aqui no controlador
        $htmlOutput = '<table>';
        $htmlOutput .= '<thead><tr><th>ID</th><th>Email</th><th>Ações</th></tr></thead>';
        $htmlOutput .= '<tbody>';
        foreach ($usuarios as $user) {
            $htmlOutput .= '<tr>';
            $htmlOutput .= '<td>' . htmlspecialchars($user['id']) . '</td>';
            $htmlOutput .= '<td>' . htmlspecialchars($user['email']) . '</td>';
            $htmlOutput .= '<td><a href="../Controller/UserController.php?action=delete&id=' . $user['id'] . '">Excluir</a></td>';
            $htmlOutput .= '</tr>';
        }
        $htmlOutput .= '</tbody>';
        $htmlOutput .= '</table>';

        // Aqui você decidiria o que fazer com $htmlOutput. Você pode:
        // 1. Ecoar a string pura (se a View for carregar isso via AJAX/fetch API)
        echo $htmlOutput;
        // 2. Ou incluir o template HTML puro e passar a variável para ele
        // header('Location: ../View/listagem_usuarios.html'); // Isso não funciona pois o HTML não pode receber a variável PHP
        
        break;
}
