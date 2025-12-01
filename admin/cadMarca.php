<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");
$nome = mysqli_real_escape_string($conn, $_POST['nome']);

$sql = "INSERT INTO marca (nome) VALUES ('$nome')";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=marcas");
    exit;
} else {
    Echo "Erro ao cadastrar marca: " . mysqli_error($conn);
    header("Location: formMarca.php");
    exit;
}