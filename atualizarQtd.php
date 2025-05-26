<?php
include("conexao.php");
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$quantidade = intval($_POST['quantidade']);
$id_produto = intval($_POST['produto_id']);
$id_usuario = $_SESSION['id'];

// Buscar o carrinho do usuário
$sql_carrinho = "SELECT id_carrinho FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql_carrinho);

if ($row = mysqli_fetch_assoc($result)) {
    $id_carrinho = $row['id_carrinho'];

    // Atualizar a quantidade
    $sql_update = "UPDATE itens_carrinho SET quantidade = $quantidade WHERE carrinho_id = $id_carrinho AND produto_id = $id_produto";
    if (mysqli_query($conn, $sql_update)) {
        header("Location: carrinho.php"); // Redireciona de volta ao carrinho
        exit;
    } else {
        echo "Erro ao atualizar o carrinho.";
    }
} else {
    echo "Carrinho não encontrado.";
}
?>