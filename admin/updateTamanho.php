<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$id_tamanho = $_POST['id_tamanho'];
$nome = $_POST['nome'];

$sql = "UPDATE tamanhos SET nome = '$nome' WHERE id_tamanho = $id_tamanho";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=tamanhos");
} else {
    header("Location: formEditTamanho.php?id_tamanho=$id_tamanho");
}