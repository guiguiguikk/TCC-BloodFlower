<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto - BloodFlower</title>

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
        .form-select {
            border-radius: 10px;
            height: 45px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
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
        <p class="subtitle">Cadastro de Novo Produto</p>

        <!-- Mensagem de erro -->
        <?php if (isset($_SESSION['erro_produto'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $_SESSION['erro_produto'] ?>
            </div>
            <?php unset($_SESSION['erro_produto']); ?>
        <?php endif; ?>

        <form action="cadProduto.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição" required>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="text" class="form-control" id="preco" name="preco" placeholder="R$ 0,00" required>
            </div>

            <div class="mb-3">
                <label for="preco_desconto" class="form-label">Preço com Desconto</label>
                <input type="text" class="form-control" id="preco_desconto" name="preco_desconto" placeholder="R$ 0,00">
            </div>

            <div class="mb-3">
                <label for="estoque" class="form-label">Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" placeholder="Quantidade em estoque" required>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem do Produto</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
            </div>

            <?php
            $sql_categoria = "SELECT * FROM categorias";
            $result_categoria = mysqli_query($conn, $sql_categoria);
            $categorias = mysqli_fetch_all($result_categoria, MYSQLI_ASSOC);

            $sql_marca = "SELECT * FROM marca";
            $result_marca = mysqli_query($conn, $sql_marca);
            $marcas = mysqli_fetch_all($result_marca, MYSQLI_ASSOC);
            ?>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="" disabled selected>Selecione a categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="marca" class="form-label">Marca</label>
                <select class="form-select" id="marca" name="marca" required>
                    <option value="" disabled selected>Selecione a marca</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca['id_marca'] ?>"><?= $marca['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">Cadastrar Produto</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
