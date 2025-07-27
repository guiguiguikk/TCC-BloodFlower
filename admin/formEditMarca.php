<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
$id_marca = $_GET['id_marca'];
$sql = "SELECT * FROM marcas WHERE id_marca = $id_marca";
$result = mysqli_query($conn, $sql);
$marca = mysqli_fetch_assoc($result);

if (!$marca) {
    echo "Marca não encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Marca</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Marca</h1>
        <form action="editarMarca.php" method="POST">
            <input type="hidden" name="id_marca" value="<?php echo $marca['id_marca']; ?>">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $marca['nome']; ?>" required>
            </div>
            <button type="submit">Salvar</button>
        </form>
    </div>
</body>
</html>