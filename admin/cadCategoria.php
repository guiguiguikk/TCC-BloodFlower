<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$nome = mysqli_real_escape_string($conn, $_POST['nome']);
$sql = "INSERT INTO categorias (nome) VALUES ('$nome')";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM?secao=categoria.php");
    exit;
} else {
    echo "Erro ao cadastrar categoria: " . mysqli_error($conn);

    exit;
}