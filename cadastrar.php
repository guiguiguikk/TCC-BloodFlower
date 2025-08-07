<?php
session_start();
include('conexao.php');

$nome = mysqli_real_escape_string($conn, trim($_POST["nome"]));
$cpf = mysqli_real_escape_string($conn, trim($_POST["cpf"]));
$telefone = mysqli_real_escape_string($conn, trim($_POST["telefone"]));
$email = mysqli_real_escape_string($conn, trim($_POST["email"]));
$password = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$data_nascimento = mysqli_real_escape_string($conn, $_POST["data_nascimento"]);

// Verifica se o email já existe
$sql_check_email = "SELECT * FROM usuarios WHERE email = '$email'";
$result_check_email = mysqli_query($conn, $sql_check_email);
if (mysqli_num_rows($result_check_email) > 0) {
    $_SESSION['erro_cadastro'] = "E-mail já cadastrado!";
    header("Location: cadastro.php");
    exit();
}

// Verifica se o CPF já existe
$sql_check_cpf = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
$result_check_cpf = mysqli_query($conn, $sql_check_cpf);
if (mysqli_num_rows($result_check_cpf) > 0) {
    $_SESSION['erro_cadastro'] = "CPF já cadastrado!";
    header("Location: cadastro.php");
    exit();
}

// Cadastra o usuário
$sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha, data_nascimento) 
        VALUES ('$nome', '$cpf', '$telefone', '$email', '$password', '$data_nascimento')";

$result = mysqli_query($conn, $sql);
$id_usuario = mysqli_insert_id($conn);

if (!$result || !$id_usuario) {
    $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário.";
    header("Location: cadastro.php");
    exit();
} else {
    // Cria o carrinho para o usuário
    $sql_carrinho = "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)";
    mysqli_query($conn, $sql_carrinho);

    // Cadastro bem-sucedido
    $_SESSION['cadastro_sucesso'] = "Cadastro realizado com sucesso! Faça login para continuar.";
    header("Location: entrar.php");
    exit();
}
?>

