<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodFlower | Novo Produto</title>

    <!-- Bootstrap -->
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
            background-color: #b02a37;
        }
    </style>
</head>

<body>
    <div class="container-produto">
        <form action="cadProduto.php" method="POST" enctype="multipart/form-data">
            <h1 class="title">Cadastro de Produto</h1>
            <p class="subtitle">Adicione um novo produto ao catálogo</p>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição" required>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="text" class="form-control" id="input-valor" name="preco" placeholder="R$ 0,00" onfocus="this.selectionStart = this.selectionEnd = this.value.length;" autofocus="true" required>
            </div>

            <div class="mb-3">
                <label for="preco_desconto" class="form-label">Preço com Desconto:</label>
                <input type="text" class="form-control" id="input_valor" name="preco_desconto" placeholder="R$ 0,00" onfocus="this.selectionStart = this.selectionEnd = this.value.length;" autofocus="true">
            </div>

            <div class="mb-3">
                <label for="estoque" class="form-label">Estoque:</label>
                <input type="number" class="form-control" id="estoque" name="estoque" placeholder="Quantidade em estoque" required>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem do Produto:</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
            </div>

            <?php
            $sql_categoria = "SELECT * FROM categorias";
            $result_categoria = mysqli_query($conn, $sql_categoria);

            $categorias = mysqli_fetch_all($result_categoria, MYSQLI_ASSOC);
            ?>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="" disabled selected>Selecione a categoria</option>
                    <?php
                    foreach ($categorias as $row_categoria) {
                    ?>
                        <option value='<?php echo $row_categoria['id_categoria']; ?>'><?php echo $row_categoria['nome']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <?php
            $sql_marca = "SELECT * FROM marca";
            $result_marca = mysqli_query($conn, $sql_marca);

            $dados_marca = mysqli_fetch_all($result_marca, MYSQLI_ASSOC);
            ?>

            <div class="mb-4">
                <label for="marca" class="form-label">Marca:</label>
                <select class="form-select" id="marca" name="marca" required>
                    <option value="" disabled selected>Selecione a marca</option>
                    <?php
                    foreach ($dados_marca as $row_marca) {
                    ?>
                        <option value='<?php echo $row_marca['id_marca']; ?>'><?php echo $row_marca['nome']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-submit">Cadastrar Produto</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>