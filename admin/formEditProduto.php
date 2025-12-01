<?php
include_once("../conexao.php");
$id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id = $id";
$result = mysqli_query($conn, $sql);
$produto = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - BloodFlower</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(145deg, #f5f5f5, #e9ecef);
            font-family: 'Rubik', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .produto-box {
            background: #fff;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.07);
            width: 100%;
            max-width: 600px;
        }

        .produto-box h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #8b0000;
            text-align: center;
            margin-bottom: 8px;
        }

        .produto-box p.subtitle {
            text-align: center;
            font-size: 1rem;
            color: #666;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control,
        .form-select,
        textarea.form-control {
            border-radius: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
        }

        textarea.form-control {
            resize: none;
        }

        .btn-submit {
            background-color: #8b0000;
            color: white;
            border-radius: 12px;
            height: 45px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #a40000;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="produto-box">
        <h1>BloodFlower</h1>
        <p class="subtitle">Editar Produto</p>

        <form action="editarProduto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" value="<?= $produto['id']; ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= $produto['nome']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="text" class="form-control" id="preco" name="preco" value="<?= $produto['preco']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="preco_desconto" class="form-label">Preço com Desconto</label>
                <input type="text" class="form-control" id="preco_desconto" name="preco_desconto" value="<?= $produto['preco_desconto']; ?>">
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= $produto['descricao']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="estoque" class="form-label">Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" value="<?= $produto['estoque']; ?>" required>
            </div>

            <?php
            $sql_categorias = "SELECT * FROM categorias";
            $result_categorias = mysqli_query($conn, $sql_categorias);
            $categorias = mysqli_fetch_all($result_categorias, MYSQLI_ASSOC);

            $sql_marcas = "SELECT * FROM marca";
            $result_marcas = mysqli_query($conn, $sql_marcas);
            $marcas = mysqli_fetch_all($result_marcas, MYSQLI_ASSOC);
            ?>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id_categoria']; ?>" <?= ($produto['categoria_id'] == $categoria['id_categoria']) ? 'selected' : ''; ?>>
                            <?= $categoria['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="marca" class="form-label">Marca</label>
                <select class="form-select" id="marca" name="marca" required>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca['id_marca']; ?>" <?= ($produto['marca_id'] == $marca['id_marca']) ? 'selected' : ''; ?>>
                            <?= $marca['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
