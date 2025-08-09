<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include ("conexao.php");

$id_usuario = $_SESSION['id'];
$id_produto = $_POST['produto_id'] or $id_produto = $_GET['produto_id'];
$vem_de = $_POST['vem_de'];

$sql_favorito = "SELECT id_favorito FROM favorito WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql_favorito);

if($dados = mysqli_fetch_assoc($result)) {
    $id_favorito = $dados['id_favorito'];

    // Remover o produto dos favoritos
    $sql_delete = "DELETE FROM item_favorito WHERE favorito_id = $id_favorito AND produto_id = $id_produto";
    if (mysqli_query($conn, $sql_delete) && $vem_de == "detalhes") {
        $_SESSION['mensagem_detalhes'] = [
            'tipo' => 'success',
            'texto' => 'Produto removido dos favoritos com sucesso!'
        ];
        header("Location: detalhes.php?id=$id_produto");
        exit;
    } elseif (mysqli_query($conn, $sql_delete) && $vem_de == "favoritos") {
        $_SESSION['mensagem_favorito'] = [
            'tipo' => 'success',
            'texto' => 'Produto removido dos favoritos com sucesso!'
        ];
        header("Location: favoritos.php");
        exit;
        
    } elseif (!mysqli_query($conn, $sql_delete) && $vem_de == "detalhes") {
        $_SESSION['mensagem_detalhes'] = [
            'tipo' => 'danger',
            'texto' => 'Erro ao remover o produto dos favoritos: ' . mysqli_error($conn)
        ];
        header("Location: detalhes.php?id=$id_produto");
        exit;
    }elseif (!mysqli_query($conn, $sql_delete) && $vem_de == "favoritos") {
        $_SESSION['mensagem_favorito'] = [
            'tipo' => 'danger',
            'texto' => 'Erro ao remover o produto dos favoritos: ' . mysqli_error($conn)
        ];
        header("Location: favoritos.php");
        exit;
    }else{
        echo "Erro ao remover o produto dos favoritos: " . mysqli_error($conn);
        exit;
    }

}else{
    echo "Favorito não encontrado.";
    exit;
}