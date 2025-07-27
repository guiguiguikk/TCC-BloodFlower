<?php
include("conexao.php");
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_produto = ($_GET['produto_id']);
$id_usuario = $_SESSION['id'];

// Buscar o carrinho do usuário
$sql_carrinho = "SELECT id_carrinho FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql_carrinho);

if ($row = mysqli_fetch_assoc($result)) {
    $id_carrinho = $row['id_carrinho'];

    // Remover o produto do carrinho
    $sql_delete = "DELETE FROM itens_carrinho WHERE carrinho_id = $id_carrinho AND produto_id = $id_produto";
    if (mysqli_query($conn, $sql_delete)) {
        header("Location: carrinho.php"); // Redireciona para o carrinho
        exit;
    } else {
        echo "Erro ao remover o item do carrinho.";
    }
} else {
    echo "Carrinho não encontrado.";
}
?>