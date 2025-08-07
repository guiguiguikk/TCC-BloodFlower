<?php
session_start();
include("conexao.php");
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$senha_atual = mysqli_real_escape_string($conn, trim($_POST['senha_atual']));
$nova_senha = mysqli_real_escape_string($conn, trim($_POST['nova_senha']));
$confirmar_senha = mysqli_real_escape_string($conn, trim($_POST['confirmar_senha']));

if ($nova_senha !== $confirmar_senha) {
    $_SESSION['erro_senha'] = "As senhas não coincidem.";
    header("Location: perfil.php?secao=senha");
    exit();
}

$sql = "SELECT senha FROM usuarios WHERE id_usuario = $id_usuario";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) === 1) {
    $usuario = mysqli_fetch_assoc($result);
    
    if (password_verify($senha_atual, $usuario['senha'])) {
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql_update = "UPDATE usuarios SET senha = '$nova_senha_hash' WHERE id_usuario = $id_usuario";
        
        if (mysqli_query($conn, $sql_update)) {
            $_SESSION['sucesso_senha'] = "Senha atualizada com sucesso!";
            header("Location: perfil.php?secao=senha");
            exit();
        } else {
            $_SESSION['erro_senha'] = "Erro ao atualizar a senha.";
            header("Location: perfil.php?secao=senha");
            exit();
        }
    } else {
        $_SESSION['erro_senha'] = "Senha atual incorreta.";
        header("Location: perfil.php?secao=senha");
        exit();
    }
} else {
    $_SESSION['erro_senha'] = "Usuário não encontrado.";
    header("Location: perfil.php?secao=senha");
    exit();
}
