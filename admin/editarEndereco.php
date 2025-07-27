<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$id_endereco = $_POST['id_endereco'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

$sql = "UPDATE enderecos SET rua = '$rua', numero = '$numero', bairro = '$bairro', cidade = '$cidade', estado = '$estado' WHERE id_endereco = $id_endereco";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Endereço atualizado com sucesso.'); window.location.href='enderecos.php';</script>";
} else {
    echo "<script>alert('Erro ao atualizar endereço: " . mysqli_error($conn) . "'); window.location.href='enderecos.php';</script>";
}