<?php
// Iniciar sessão apenas se não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirecionar para login se não estiver autenticado
    header('Location: /Calculadora-de-CO2/index.php');
    exit;
}
?>