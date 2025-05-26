<?php
session_start();
include("conexao.php");

$id_usuario = $_POST["id_usuario"];
$cep = mysqli_real_escape_string($conn, $_POST["cep"]);
$rua = mysqli_real_escape_string($conn, $_POST["rua"]);
$numero = mysqli_real_escape_string($conn, $_POST["numero"]);
$bairro = mysqli_real_escape_string($conn, $_POST["bairro"]);
$cidade = mysqli_real_escape_string($conn, $_POST["cidade"]);
$estado = mysqli_real_escape_string($conn, $_POST["estado"]);

if( is_numeric($cep) && is_numeric($numero) ){
    $sql = "INSERT INTO enderecos (cep, rua, numero, bairro, cidade, estado, usuario_id) VALUES ('$cep', '$rua', '$numero', '$bairro', '$cidade', '$estado', '$id_usuario')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: carrinho.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar endereço.');</script>";
        echo "<script>window.location.href='cadastrarEndereco.php';</script>";
    }
} else {
    echo "<script>alert('CEP e número devem ser numéricos.');</script>";
    echo "<script>window.location.href='cadEndereco.php';</script>";
}