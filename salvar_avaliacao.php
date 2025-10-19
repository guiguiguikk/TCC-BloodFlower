<?php
session_start();
if(!isset($_SESSION["id"]) || $_SESSION["tipo"] !="cliente"){
    header("Location: entrar.php");
    exit;
}
include("conexao.php");

$id_produto = $_POST['produto_id'];
$nota = $_POST['nota'];
$cometario = $_POST['comentario'];

$id_usuario = $_SESSION['id'];
 

$sql_avaliaçao = "INSERT INTO `avaliacoes`( `usuario_id`, `produto_id`, `comentario`, `nota`)
 VALUES ('$id_usuario','$id_produto','$cometario','$nota]')";

$result_avaliaçao = mysqli_query($conn, $sql_avaliaçao);

if($result_avaliaçao){
    $_SESSION['avaliacao_mensagem'] = ["texto" => "Avaliação salva com sucesso!", "tipo" => "success"];
    header("Location: detalhes.php?id=$id_produto");
    exit;
} else {
    $_SESSION['avaliacao_mensagem'] = ["texto" => "Erro ao salvar avaliação.", "tipo" => "danger"];
    header("Location: detalhes.php?id=$id_produto");
}