<?php
require_once __DIR__ . '/../Controller/protect.php';
require_once __DIR__ . '/../Controller/Conexao.php';

$con = new Conexao();
$mysqli = $con->getConnection();

$id = $_SESSION['id'];

// 1. Deletar da tabela Conta
$stmt = $mysqli->prepare("DELETE FROM Conta WHERE cod_user = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// 2. Deletar da tabela usuario
$stmt = $mysqli->prepare("DELETE FROM usuario WHERE cod = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// 3. Logout automático
session_destroy();

echo "<script>alert('Conta excluída com sucesso!'); window.location.href='/Calculadora-de-CO2/Tela de Login/index.php';</script>";
?>
