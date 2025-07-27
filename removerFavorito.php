<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include ("conexao.php");

$id_usuario = $_SESSION['id'];
$id_produto = ($_GET['produto_id']);

$sql_carrinho = "SELECT id_carrinho FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql_carrinho);

if($dados = mysqli_fetch_assoc($result)) {
    $id_carrinho = $dados['id_carrinho'];

    // Remover o produto dos favoritos
    $sql_delete = "DELETE FROM favoritos WHERE usuario_id = $id_usuario AND produto_id = $id_produto";
    if (mysqli_query($conn, $sql_delete)) {
        header("Location: favoritos.php");
        exit;
    } else {
        echo "Erro ao remover o item dos favoritos.";
    }
} else {
    echo "Carrinho não encontrado.";
}