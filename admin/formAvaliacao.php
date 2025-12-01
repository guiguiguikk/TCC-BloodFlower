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
        <p class="subtitle">Cadastro de Nova Avaliação</p>

        <!-- Mensagem de erro -->
        <?php if (isset($_SESSION['erro_produto'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $_SESSION['erro_produto'] ?>
            </div>
            <?php unset($_SESSION['erro_produto']); ?>
        <?php endif; ?>

        <form action="cadAvaliacao.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Comentario</label>
                <input type="text" class="form-control" id="nome" name="comentario" placeholder="Digite o comentario" required>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Nota</label>
                <input type="number" class="form-control" id="preco" name="nota" placeholder="Nota de 1 a 5" required min="1" max="5">
            </div>


            <?php
            $sql_usuarios = "SELECT * FROM usuarios";
            $result_usuarios = mysqli_query($conn, $sql_usuarios);
            $usuarios = mysqli_fetch_all($result_usuarios, MYSQLI_ASSOC);

            $sql_produtos = "SELECT * FROM produtos";
            $result_produtos = mysqli_query($conn, $sql_produtos);
            $produtos = mysqli_fetch_all($result_produtos, MYSQLI_ASSOC);
            ?>

            <div class="mb-3">
                <label for="categoria" class="form-label">Usuário</label>
                <select class="form-select" id="categoria" name="usuario" required>
                    <option value="" disabled selected>Selecione o usuario
                    </option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['id_usuario'] ?>"><?= $usuario['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="marca" class="form-label">Produto</label>
                <select class="form-select" id="marca" name="produto" required>
                    <option value="" disabled selected>Selecione a marca</option>
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?= $produto['id'] ?>"><?= $produto['nome'] ?></option>
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
