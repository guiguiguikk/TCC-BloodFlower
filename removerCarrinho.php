<?php
include("conexao.php");
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_produto = $_POST['produto_id'] or $id_produto = $_GET['produto_id'];
$id_usuario = $_SESSION['id'];
$vem_de = $_POST['vem_de'];

// Buscar o carrinho do usuário
$sql_carrinho = "SELECT id_carrinho FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql_carrinho);

if ($row = mysqli_fetch_assoc($result)) {
    $id_carrinho = $row['id_carrinho'];

    // Remover o produto do carrinho
    $sql_delete = "DELETE FROM itens_carrinho WHERE carrinho_id = $id_carrinho AND produto_id = $id_produto";
    if (mysqli_query($conn, $sql_delete) && $vem_de == "detalhes") {
        $_SESSION['mensagem_detalhes'] = [
            'tipo' => 'success',
            'texto' => 'Produto removido do carrinho com sucesso!'
        ];
        header("Location: detalhes.php?id=$id_produto");
        exit;
    } elseif (mysqli_query($conn, $sql_delete) && $vem_de == "carrinho") {
        $_SESSION['mensagem_carrinho'] = [
            'tipo' => 'success',
            'texto' => 'Produto removido do carrinho com sucesso!'
        ];
        header("Location: carrinho.php");
        exit;
    } elseif (!mysqli_query($conn, $sql_delete) && $vem_de == "detalhes") {
        $_SESSION['mensagem_detalhes'] = [
            'tipo' => 'danger',
            'texto' => 'Erro ao remover o produto do carrinho: ' . mysqli_error($conn)
        ];
        header("Location: detalhes.php?id=$id_produto");
        exit;
    } elseif (!mysqli_query($conn, $sql_delete) && $vem_de == "carrinho") {
        $_SESSION['mensagem_carrinho'] = [
            'tipo' => 'danger',
            'texto' => 'Erro ao remover o produto do carrinho: ' . mysqli_error($conn)
        ];
        header("Location: carrinho.php");
        exit;
        
    } elseif (mysqli_query($conn, $sql_delete) && $vem_de == "favoritos") {
        $_SESSION['mensagem_carrinho'] = [
            'tipo' => 'success',
            'texto' => 'Produto removido do carrinho com sucesso!'
        ];
        header("Location: favoritos.php");
        exit;
    } elseif (!mysqli_query($conn, $sql_delete) && $vem_de == "favoritos") {
        $_SESSION['mensagem_carrinho'] = [
            'tipo' => 'danger',
            'texto' => 'Erro ao remover o produto do carrinho: ' . mysqli_error($conn)
        ];
        header("Location: carrinho.php");
        exit;
        
    } else {
        echo "Erro ao remover o item do carrinho.";
    }
} else {
    echo "Carrinho não encontrado.";
}
?>