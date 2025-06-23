<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: entrar.php");
    exit;
}
include("conexao.php");

$id_usuario = $_SESSION['id'];

// buscar o carrinho do usuário
$sql = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // se não existir, cria um novo carrinho
    mysqli_query($conn, "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)");
    $id_carrinho = mysqli_insert_id($conn);
} else {
    $carrinho = mysqli_fetch_assoc($result);
    $id_carrinho = $carrinho['id_carrinho'];
}

// buscar os itens do carrinho
$sql_itens = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho";
$itens = mysqli_query($conn, $sql_itens);



