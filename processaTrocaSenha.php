<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$email = $_SESSION['email_recuperacao'];

$nova_senha = $_POST['nova_senha'];
$confirmar_senha = $_POST['confirmar_senha'];

if ($nova_senha !== $confirmar_senha) {
    $_SESSION['erro_senha'] = "As senhas não coincidem. Tente novamente.";
    header("Location: trocarSenha.php");
    exit;
}
include("conexao.php");

$senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

$sql = "UPDATE usuarios SET senha = '$senha_hash' WHERE email = '$email'";
if (mysqli_query($conn, $sql)) {
    unset($_SESSION['email_recuperacao']);
    $_SESSION['sucesso_senha'] = "Senha alterada com sucesso! Faça login com sua nova senha.";
    header("Location: entrar.php");
    exit;
} else {
    $_SESSION['erro_senha'] = "Erro ao alterar a senha. Tente novamente.";
    header("Location: trocarSenha.php");
    exit;
}