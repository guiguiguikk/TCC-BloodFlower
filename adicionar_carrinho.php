<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

include("conexao.php");

$id_usuario = $_SESSION["id"];
$id_produto = $_POST["produto_id"];


//verifica se o carrinho já existe
$sql = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) == 0) {

    // Carrinho nao existe, cria um novo
    $sql_criaCarrinho = "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)";
    mysqli_query($conn, $sql_criaCarrinho);
    $id_carrinho = mysqli_insert_id($conn);

    // Adiciona o produto ao carrinho
    $sql_adicionaProduto = "INSERT INTO itens_carrinho (carrinho_id, produto_id) VALUES ($id_carrinho, $id_produto)";
    mysqli_query($conn, $sql_adicionaProduto);

    echo "<script>alert('Produto adicionado ao carrinho!');</script>";
    echo "<script>window.location.href='index.php';</script>";




}else {
    // Carrinho já existe, adiciona o produto ao carrinho existente
    $row = mysqli_fetch_assoc($result);
    $id_carrinho = $row["id_carrinho"];

    // Verifica se o produto já está no carrinho
    $sql_check = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho AND produto_id = $id_produto";
    $result_check = mysqli_query($conn, $sql_check);



    if (mysqli_num_rows($result_check) == 0) {
        // Adiciona o produto ao carrinho
        $sql = "INSERT INTO itens_carrinho (carrinho_id, produto_id) VALUES ($id_carrinho, $id_produto)";
        mysqli_query($conn, $sql);

        echo "<script>alert('Produto adicionado ao carrinho!');</script>";
        echo "<script>window.location.href='carrinho.php';</script>";
    } else {
        // Produto já está no carrinho
        echo "<script>alert('Produto já está no carrinho!');</script>";
        echo "<script>window.location.href='detalhes.php?id=$id_produto';</script>";
    }


}

