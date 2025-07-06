<?php

session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

include("conexao.php");

$id_usuario = $_SESSION["id"];
$id_produto = $_POST["produto_id"];


//verifica se o favorito já existe
$sql = "SELECT * FROM favorito WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) == 0) {

    // Favorito nao existe, cria um novo
    $sql_criaFavorito = "INSERT INTO favorito (usuario_id) VALUES ($id_usuario)";
    mysqli_query($conn, $sql_criaFavorito);
    $id_favorito = mysqli_insert_id($conn);

    // Adiciona o produto ao favorito
    $sql_adicionaProduto = "INSERT INTO item_favorito (favorito_id, produto_id) VALUES ($id_favorito, $id_produto)";
    mysqli_query($conn, $sql_adicionaProduto);

    echo "<script>alert('Produto adicionado aos favoritos!');</script>";
    echo "<script>window.location.href='index.php';</script>";




}else {
    // favorito já existe, adiciona o produto ao favorito existente
    $row = mysqli_fetch_assoc($result);
    $id_favorito = $row["id_favorito"];

    // Verifica se o produto já está no favorito
    $sql_check = "SELECT * FROM item_favorito WHERE favorito_id = $id_favorito AND produto_id = $id_produto";
    $result_check = mysqli_query($conn, $sql_check);



    if (mysqli_num_rows($result_check) == 0) {
        // Adiciona o produto ao favorito
        $sql = "INSERT INTO item_favorito (favorito_id, produto_id) VALUES ($id_favorito, $id_produto)";
        mysqli_query($conn, $sql);

        echo "<script>alert('Produto adicionado aos favoritos!');</script>";
        echo "<script>window.location.href='favoritos.php';</script>";
    } else {
        // Produto já está nos favoritos
        echo "<script>alert('Produto já está nos favoritos!');</script>";
        echo "<script>window.location.href='detalhes.php?id=$id_produto';</script>";
    }


}