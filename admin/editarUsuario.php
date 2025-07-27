<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

if (isset($_POST['id'])) {
    $id_usuario = $_POST['id'];
    echo "ID do usuário: $id_usuario"; // Debugging line, remove in production
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', cpf = '$cpf', telefone = '$telefone', data_nascimento = '$data_nascimento' WHERE id_usuario = $id_usuario";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die(mysqli_error($conn)); // Debugging line, remove in production
    }

    header("Location: usuarios.php");
    exit;
}
?>