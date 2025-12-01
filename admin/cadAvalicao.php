<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

// Receber os dados do formulário
$comentario = mysqli_real_escape_string($conn, $_POST['comentario']);
$nota = (int)$_POST['nota'];
$usuario_id = (int)$_POST['usuario'];
$produto_id = (int)$_POST['produto'];


// Inserir no banco de dados
$sql = "INSERT INTO avaliacoes (comentario, nota, usuario_id, produto_id) VALUES ('$comentario', $nota, $usuario_id, $produto_id)";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=avaliacoes");
    exit;
} else {
    $_SESSION['erro_produto'] = "Erro ao cadastrar avaliação: " . mysqli_error($conn);
    header("Location: formAvaliacao.php");
    exit;
}

?>