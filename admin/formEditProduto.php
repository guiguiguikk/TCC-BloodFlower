<?php
include_once("../conexao.php");
$id = $_GET['id_produto'];

$sql = "SELECT * FROM produtos WHERE id = $id";
$result = mysqli_query($conn, $sql);
$produto = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 40px 20px;
        }
        .container-produto {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .title {
            text-align: center;
            color: #dc3545;
            font-weight: bold;
        }
        .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .btn-submit {
            background-color: #dc3545;
            color: white;
            font-weight: 500;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            transition: 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="container-produto">
        <h1 class="title">Editar Produto</h1>
        <p class="subtitle">Atualize as informações do produto</p>
        <form action="editarProduto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $produto['nome']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="text" step="0.01" class="form-control" id="input_valor" name="preco" value="<?php echo $produto['preco']; ?>" onfocus="this.selectionStart = this.selectionEnd = this.value.length;" autofocus="true" required>
            </div>
            <div class="mb-3">
                <label for="preco_desconto" class="form-label">Preço com Desconto:</label>
                <input type="text" step="0.01" class="form-control" id="input_valor" name="preco_desconto" value="<?php echo $produto['preco_desconto']; ?>" onfocus="this.selectionStart = this.selectionEnd = this.value.length;" autofocus="true">
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php echo $produto['descricao']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="estoque" class="form-label">Estoque:</label>
                <input type="number" class="form-control" id="estoque" name="estoque" value="<?php echo $produto['estoque']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <?php
                    $sql_categorias = "SELECT * FROM categorias";
                    $result_categorias = mysqli_query($conn, $sql_categorias);
                    while ($categoria = mysqli_fetch_assoc($result_categorias)) {
                        $selected = ($produto['categoria_id'] == $categoria['id_categoria']) ? 'selected' : '';
                        echo "<option value='{$categoria['id_categoria']}' $selected>{$categoria['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <select class="form-select" id="marca" name="marca" required>
                    <?php
                    $sql_marcas = "SELECT * FROM marca";
                    $result_marcas = mysqli_query($conn, $sql_marcas);
                    while ($marca = mysqli_fetch_assoc($result_marcas)) {
                        $selected = ($produto['marca_id'] == $marca['id_marca']) ? 'selected' : '';
                        echo "<option value='{$marca['id_marca']}' $selected>{$marca['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn-submit">Salvar Alterações</button>
        </form>
    </div>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
