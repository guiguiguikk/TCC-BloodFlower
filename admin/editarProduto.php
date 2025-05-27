<?php
include("../conexao.php");

$id = $_POST['id_produto'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];
$descricao = $_POST['descricao'];
$estoque = $_POST['quantidade'];
$categoria = $_POST['categoria'];

$sql = "UPDATE produtos SET nome = '$nome', preco = '$preco', descricao = '$descricao', estoque = '$estoque', categoria = '$categoria' WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: inicioADM.php");
    
}else{
    echo "Erro ao editar produto: " . mysqli_error($conn);
    echo "<a href='inicioADM.php'><button>Voltar</button></a>";
}