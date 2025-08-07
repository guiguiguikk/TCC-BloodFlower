<?php
session_start();
include("conexao.php");
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
$id_usuario = $_SESSION["id"];
$nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
$email = mysqli_real_escape_string($conn, trim($_POST['email']));
$telefone = mysqli_real_escape_string($conn, trim($_POST['telefone']));
$data_nascimento = mysqli_real_escape_string($conn, trim($_POST['data_nascimento']));

$sql = "UPDATE usuarios SET nome = '$nome', email = '$email', telefone = '$telefone', data_nascimento = '$data_nascimento' WHERE id_usuario = $id_usuario";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['erro_atualizacao'] = "Erro ao atualizar perfil.";
    header("Location: perfil.php?secao=perfil");
    exit();
} else {
    $_SESSION['sucesso_atualizacao'] = "Perfil atualizado com sucesso!";
    header("Location: perfil.php?secao=perfil");
    exit();
}