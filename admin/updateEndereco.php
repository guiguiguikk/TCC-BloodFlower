<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$id_endereco = $_POST['id_endereco'];
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$id_usuario = $_POST['id_usuario'];

$sql = "UPDATE enderecos SET cep = '$cep', rua = '$rua', numero = '$numero', bairro = '$bairro', cidade = '$cidade', estado = '$estado', id_usuario = $id_usuario WHERE id_endereco = $id_endereco";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=enderecos");
} else {
    header("Location: formEditEndereco.php?id_endereco=$id_endereco");
}