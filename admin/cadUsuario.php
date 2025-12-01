<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");

$nome = mysqli_real_escape_string($conn, $_POST['nome']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
$cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
$data_nascimento = mysqli_real_escape_string($conn, $_POST['data_nascimento']);

$sql = "INSERT INTO usuarios (nome, email, senha, telefone, cpf, data_nascimento) VALUES ('$nome', '$email', '$senha', '$telefone', '$cpf', '$data_nascimento')";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=usuario");
    exit;
} else {
    $_SESSION['erro_produto'] = "Erro ao cadastrar usuário: " . mysqli_error($conn);
    header("Location: formUsuario.php");
    exit;
}