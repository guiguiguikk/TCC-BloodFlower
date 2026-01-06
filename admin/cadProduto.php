<?php

use FontLib\Table\Type\head;

include("../conexao.php");

$nome = mysqli_real_escape_string($conn, trim($_POST["nome"]));
$preco = mysqli_real_escape_string($conn, trim($_POST["preco"]));
$preco_desconto = isset($_POST["preco_desconto"]) ? mysqli_real_escape_string($conn, trim($_POST["preco_desconto"])) : null;
$descricao = mysqli_real_escape_string($conn, trim($_POST["descricao"]));
$categoria = mysqli_real_escape_string($conn, trim($_POST["categoria"]));
$marca = mysqli_real_escape_string($conn, trim($_POST["marca"]));

$tamanhos = isset($_POST['tamanho']) ? $_POST['tamanho'] : [];
$qtdP = isset($_POST['quantP']) ? (int)$_POST['quantP'] : 0;
$qtdM = isset($_POST['quantM']) ? (int)$_POST['quantM'] : 0;
$qtdG = isset($_POST['quantG']) ? (int)$_POST['quantG'] : 0;
$qtdGG = isset($_POST['quantGG']) ? (int)$_POST['quantGG'] : 0;

$estoque = $qtdG + $qtdGG + $qtdM + $qtdP;


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
    echo "<script>window.location.href='formProduto.php';</script>";
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
$id_produto = mysqli_insert_id($conn);



if (!$result) {
    echo "<script>alert('Erro ao cadastrar produto.');</script>";
    echo "<script>window.location.href='formProduto.php';</script>";
    
}


//cadastrar tamanhos e quantidades


for($i = 0; $i < count($tamanhos); $i++) {
    $tamanho = $tamanhos[$i];
    $quantidade = 0;

    switch($tamanho) {
        case 'P':
            $select_tamanho = "SELECT id FROM tamanhos WHERE nome = 'P'";
            $result_tamanho = mysqli_query($conn, $select_tamanho);
            $row_tamanho = mysqli_fetch_assoc($result_tamanho);
            $tamanho_id = $row_tamanho['id'];

            $quantidade = $qtdP;
            break;
        case 'M':

            $select_tamanho = "SELECT id FROM tamanhos WHERE nome = 'M'";
            $result_tamanho = mysqli_query($conn, $select_tamanho);
            $row_tamanho = mysqli_fetch_assoc($result_tamanho);
            $tamanho_id = $row_tamanho['id'];

            $quantidade = $qtdM;
            break;
        case 'G':
            $select_tamanho = "SELECT id FROM tamanhos WHERE nome = 'G'";
            $result_tamanho = mysqli_query($conn, $select_tamanho);
            $row_tamanho = mysqli_fetch_assoc($result_tamanho);
            $tamanho_id = $row_tamanho['id'];

            $quantidade = $qtdG;
            break;
        case 'GG':
            $select_tamanho = "SELECT id FROM tamanhos WHERE nome = 'GG'";
            $result_tamanho = mysqli_query($conn, $select_tamanho);
            $row_tamanho = mysqli_fetch_assoc($result_tamanho);
            $tamanho_id = $row_tamanho['id'];
            $quantidade = $qtdGG;
            break;
    }

    $sql_tamanho = "INSERT INTO produto_tamanhos (produto_id, tamanho_id, quantidade) VALUES ($id_produto, '$tamanho_id', '$quantidade')";
    $result_tamanho = mysqli_query($conn, $sql_tamanho);

    if (mysqli_error($conn)) {
        echo "Erro ao inserir tamanho $tamanho: " . mysqli_error($conn);
    }

    if($result_tamanho && $result){
        header("Location: inicioADM.php");
    } else {
        echo "<script>alert('Erro ao cadastrar tamanhos.');</script>";
        //echo "<script>window.location.href='cadProduto.php';</script>";
        
    }
}

