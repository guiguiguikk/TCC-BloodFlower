<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");

$id = $_POST['id_produto'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];
$descricao = $_POST['descricao'];
$estoque = $_POST['estoque'];
$categoria = $_POST['categoria'];
$marca = $_POST['marca'];
$preco_desconto = $_POST['preco_desconto'];

$sql = "UPDATE produtos SET nome = '$nome', preco = '$preco', descricao = '$descricao', estoque = '$estoque', categoria_id = '$categoria', marca_id = '$marca', preco_desconto = '$preco_desconto' WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: inicioADM.php");
    
}else{
    echo "Erro ao editar produto: " . mysqli_error($conn);
    echo "<a href='inicioADM.php'><button>Voltar</button></a>";
}