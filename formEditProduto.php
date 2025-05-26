<?php
include_once("conexao.php");
$id = $_GET['id_produto'];

$sql = "SELECT * FROM produtos WHERE id_produto = '$id'";
$result = mysqli_query($conn,$sql);

$rows = mysqli_fetch_array($result);





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodFloer</title>
</head>
<body>
    <h1>Cadastro de Produto</h1>
    <form action="editarProduto.php" method="POST">
        <input type="hidden" id="nome" name="id_produto" placeholder="Nome" value="<?php echo $rows['id_produto']; ?>" required><br>
        <label for="nome">Nome do Produto:</label><br>
        <input type="text" id="nome" name="nome" placeholder="Nome" value="<?php echo $rows['nome']; ?>" required><br><br>

        <label for="preco">Preço</label><br>
        <input type="text" id="preco" name="preco" placeholder="Preço" value="<?php echo $rows['preco']; ?>" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <input type="text" id="descricao" name="descricao" rows="4" cols="50" placeholder="Descrição" value="<?php echo $rows['descricao']; ?>" required></textarea><br><br>

        <label for="quantidade">Quantidade:</label><br>
        <input type="number" id="quantidade" name="quantidade" placeholder="Quantidade" value="<?php echo $rows['estoque']; ?>" required><br><br>

        <label for="categoria">Categoria:</label><br>
        <select id="categoria" name="categoria" required>
            <option value="camiseta">Camiseta</option>
            <option value="calca">Calça</option>
            <option value="bone">Boné</option>
            <option value="outros">Outros</option>
            </select><br><br>

            <input type="submit" value="Cadastrar Produto">
            </form>


</body>
</html>








