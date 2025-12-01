<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$cep = mysqli_real_escape_string($conn, $_POST['cep']);
$rua = mysqli_real_escape_string($conn, $_POST['rua']); 
$numero = mysqli_real_escape_string($conn, $_POST['numero']);
$bairro = mysqli_real_escape_string($conn, $_POST['bairro']);
$cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
$estado = mysqli_real_escape_string($conn, $_POST['estado']);
$id_usuario = mysqli_real_escape_string($conn, $_POST['id_usuario']);

$sql = "INSERT INTO `enderecos`(`usuario_id`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`) VALUES ('$id_usuario', '$cep', '$rua', '$numero', '$bairro', '$cidade', '$estado')";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=enderecos");
    exit;
} else {
    echo "Erro ao cadastrar endereço: " . mysqli_error($conn);
    exit;
}