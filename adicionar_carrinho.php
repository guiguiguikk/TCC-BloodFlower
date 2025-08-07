<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

include("conexao.php");

$id_usuario = $_SESSION["id"];
$id_produto = $_POST["produto_id"] ?? null;

if (!$id_produto) {
    header("Location: index.php");
    exit;
}

// Verifica se o carrinho já existe
$sql = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // Cria novo carrinho
    $sql_criaCarrinho = "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)";
    mysqli_query($conn, $sql_criaCarrinho);
    $id_carrinho = mysqli_insert_id($conn);
} else {
    $row = mysqli_fetch_assoc($result);
    $id_carrinho = $row["id_carrinho"];
}

// Verifica se o produto já está no carrinho
$sql_check = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho AND produto_id = $id_produto";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) == 0) {
    // Adiciona produto
    $sql = "INSERT INTO itens_carrinho (carrinho_id, produto_id) VALUES ($id_carrinho, $id_produto)";
    mysqli_query($conn, $sql);
    $_SESSION['mensagem_carrinho'] = [
        'tipo' => 'success',
        'texto' => 'Produto adicionado ao carrinho com sucesso!'
    ];
    header("Location: carrinho.php");
    exit;
} else {
    // Já no carrinho
    $_SESSION['mensagem_detalhes'] = [
        'tipo' => 'warning',
        'texto' => 'Este produto já está no seu carrinho.'
    ];
    header("Location: detalhes.php?id=$id_produto");
    exit;
}
