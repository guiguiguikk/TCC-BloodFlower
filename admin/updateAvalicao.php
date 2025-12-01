<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$comentario = mysqli_real_escape_string($conn, $_POST['comentario']);
$nota = mysqli_real_escape_string($conn, $_POST['nota']);
$usuario_id = mysqli_real_escape_string($conn, $_POST['usuario']);
$produto_id = mysqli_real_escape_string($conn, $_POST['produto']);
$id_avaliacao = mysqli_real_escape_string($conn, $_POST['id_avaliacao']);

$sql = "UPDATE avaliacoes SET comentario='$comentario', nota=$nota, usuario_id=$usuario_id, produto_id=$produto_id WHERE id_avaliacao=$id_avaliacao";

if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?msg=avaliacao_atualizada");
    exit;
} else {
    $_SESSION['erro_produto'] = "Erro ao atualizar avaliação: " . mysqli_error($conn);
    header("Location: formEditAvaliacao.php?id_avaliacao=$id_avaliacao");
    exit;
}