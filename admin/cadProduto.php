<?php
include("../conexao.php");

$nome = mysqli_real_escape_string($conn, trim($_POST["nome"]));
$preco = mysqli_real_escape_string($conn, trim($_POST["preco"]));
$preco_desconto = isset($_POST["preco_desconto"]) ? mysqli_real_escape_string($conn, trim($_POST["preco_desconto"])) : null;
$descricao = mysqli_real_escape_string($conn, trim($_POST["descricao"]));
$estoque = mysqli_real_escape_string($conn, trim($_POST["estoque"]));
$categoria = mysqli_real_escape_string($conn, trim($_POST["categoria"]));
$marca = mysqli_real_escape_string($conn, trim($_POST["marca"]));

 var_dump($_FILES);
 
 
$imagem = $_FILES['imagem']['name'];
$imagem_tmp = $_FILES['imagem']['tmp_name'];
$imagem_dir = "../imagens/" . $imagem;

move_uploaded_file($imagem_tmp, $imagem_dir);



// Verifica se o nome do produto já existe
$sql_check_nome = "SELECT * FROM produtos WHERE nome = '$nome'";
$result_check_nome = mysqli_query($conn, $sql_check_nome);
if (mysqli_num_rows($result_check_nome) > 0) {
    echo "<script>alert('Produto já cadastrado!');</script>";
    echo "<script>window.location.href='cadProduto.html';</script>";
    exit();
}


// Verifica se o preço é um número válido
if (!is_numeric($preco)) {
    echo "<script>alert('Preço inválido!');</script>";
    echo "<script>window.location.href='formProduto.php';</script>";
    exit();
}



$sql = "INSERT INTO produtos (nome, preco, preco_desconto, descricao, estoque, categoria_id, marca_id, imagem)
VALUES ('$nome', '$preco', '$preco_desconto', '$descricao', '$estoque', '$categoria', '$marca', '$imagem')";

$result = mysqli_query($conn, $sql);



if ($result) {
    header("Location: inicioADM.php");
    exit();
} else {

    echo "<script>alert('Erro ao cadastrar produto.');</script>";
    echo "<script>window.location.href='cadProduto.php';</script>";
    
}



