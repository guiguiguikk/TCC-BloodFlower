<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
$id_endereco = $_GET['id_endereco'];
$sql = "SELECT * FROM enderecos WHERE id_endereco = $id_endereco";
$result = mysqli_query($conn, $sql);
$endereco = mysqli_fetch_assoc($result);

if (!$endereco) {
    echo "Endereço não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Endereço</title>
</head>
<body>
    <h1>Editar Endereço</h1>
    <form action="editarEndereco.php" method="POST">
        <input type="hidden" name="id_endereco" value="<?php echo $endereco['id_endereco']; ?>">
        <label for="rua">Rua:</label>
        <input type="text" id="rua" name="rua" value="<?php echo $endereco['rua']; ?>" required>
        <br>
        <label for="numero">Número:</label>
        <input type="text" id="numero" name="numero" value="<?php echo $endereco['numero']; ?>" required>
        <br>
        <label for="bairro">Bairro:</label>
        <input type="text" id="bairro" name="bairro" value="<?php echo $endereco['bairro']; ?>" required>
        <br>
        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" value="<?php echo $endereco['cidade']; ?>" required>
        <br>
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" value="<?php echo $endereco['estado']; ?>" required>
        <br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>