<?php
require_once __DIR__ . '/../Controller/protect.php';
require_once __DIR__ . '/../Controller/Conexao.php';

$con = new Conexao();
$mysqli = $con->getConnection();

$id = $_SESSION['id']; // cod_user
$novo_email = $_POST['email'];
$nome = $_POST['nome'];
$senha_atual = $_POST['senha_atual'];
$nova_senha = $_POST['nova_senha'];

// 1. Verificar senha atual
$stmt = $mysqli->prepare("SELECT senha FROM usuario WHERE cod = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($senha_bd);
$stmt->fetch();
$stmt->close();

if (!password_verify($senha_atual, $senha_bd)) {
    die("<script>alert('Senha atual incorreta!'); window.history.back();</script>");
}

// 2. Atualizar email na tabela usuario
$stmt = $mysqli->prepare("UPDATE usuario SET email = ? WHERE cod = ?");
$stmt->bind_param("si", $novo_email, $id);
$stmt->execute();
$stmt->close();

// 3. Atualizar nome e email na tabela Conta
$stmt = $mysqli->prepare("UPDATE Conta SET nome = ?, email = ? WHERE cod_user = ?");
$stmt->bind_param("ssi", $nome, $novo_email, $id);
$stmt->execute();
$stmt->close();

// 4. Atualizar senha se enviada
if (!empty($nova_senha)) {
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("UPDATE usuario SET senha = ? WHERE cod = ?");
    $stmt->bind_param("si", $senha_hash, $id);
    $stmt->execute();
    $stmt->close();
}

echo "<script>alert('Informações atualizadas com sucesso!'); window.location.href='conta.php';</script>";
?>
