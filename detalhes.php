<?php
session_start();
include("conexao.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM produtos WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Produto não encontrado.";
    exit;
}

$produto = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produto['nome']) ?> | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Rubik', sans-serif;
        }

        .produto-container {
            padding: 100px 20px 60px;
        }

        .imagem-box {
            background: #fff;
            padding: 25px;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }

        .imagem-box img {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
        }

        .info-produto h1 {
            font-weight: 700;
            font-size: 2.2rem;
            color: #8b0000;
            margin-bottom: 10px;
        }

        .preco-produto {
            font-size: 1.8rem;
            color: #28a745;
            font-weight: bold;
        }

        .descricao-produto {
            font-size: 1.05rem;
            color: #555;
            margin: 20px 0;
            white-space: pre-line;
        }

        .extra-info {
            margin-bottom: 20px;
        }

        .extra-info i {
            color: #8b0000;
            margin-right: 8px;
        }

        .botoes-produto {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .botoes-produto .btn {
            font-weight: 600;
            font-size: 1rem;
            padding: 12px;
            border-radius: 12px;
        }

        footer {
            background: #f8f8f8;
            padding: 30px 0;
            font-size: 0.95rem;
        }

        footer h5 {
            color: #8b0000;
        }

        .footer-bottom {
            border-top: 1px solid #ddd;
            text-align: center;
            padding-top: 15px;
            color: #999;
        }
    </style>
</head>

<body>

    <!-- NAVBAR (igual ao index.php) -->
    <nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="imagens/LogoBloodFlower.png" alt="Logo" height="48">
                <span class="ms-2 fw-bold text-danger fs-4">BloodFlower</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <div class="d-flex gap-3 align-items-center">
                    <?php if (!isset($_SESSION['email'])) { ?>
                        <a href="entrar.php" class="text-dark" title="Entrar"><i class="bi bi-box-arrow-in-right fs-4"></i></a>
                    <?php } else { ?>
                        <a href="perfil.php" class="text-dark" title="Meu Perfil"><i class="bi bi-person-circle fs-4"></i></a>
                    <?php } ?>
                    <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart fs-4"></i></a>
                    <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
                    <?php if (isset($_SESSION['email'])) { ?>
                        <a href="logoff.php" class="text-dark" title="Sair"><i class="bi bi-box-arrow-right fs-4"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTEÚDO -->
    <div class="container produto-container">
        <?php if (isset($_SESSION['mensagem_detalhes'])): ?>
            <div class="alert alert-<?= $_SESSION['mensagem_detalhes']['tipo']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensagem_detalhes']['texto']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
            <?php unset($_SESSION['mensagem_detalhes']); ?>
        <?php endif; ?>

        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="imagem-box">
                    <img src="imagens/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                </div>
            </div>
            <div class="col-lg-6 info-produto">
                <h1><?= htmlspecialchars($produto['nome']) ?></h1>
                <div class="preco-produto mb-3">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>

                <div class="extra-info">
                    <p><i class="bi bi-truck"></i> Entrega rápida disponível</p>
                    <p><i class="bi bi-box-seam"></i> Estoque limitado</p>
                </div>

                <div class="descricao-produto"><?= nl2br(htmlspecialchars($produto['descricao'])) ?></div>

                <div class="botoes-produto mt-4">
                    <form method="POST" action="adicionar_carrinho.php">
                        <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                        <button type="submit" class="btn btn-danger w-100"><i class="bi bi-cart-plus me-2"></i> Adicionar ao Carrinho</button>
                    </form>

                    <form method="POST" action="add_favorito.php">
                        <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                        <button type="submit" class="btn btn-outline-dark w-100"><i class="bi bi-heart me-2"></i> Favoritar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER (igual ao index.php) -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>BloodFlower</h5>
                    <p>Vista-se com originalidade e atitude. Roupas alternativas para quem quer se destacar.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-muted text-decoration-none">Início</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Loja</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Contato</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contato</h5>
                    <p><i class="bi bi-envelope"></i> contato@bloodflower.com</p>
                    <p><i class="bi bi-instagram"></i> @bloodflower</p>
                </div>
            </div>
            <div class="footer-bottom mt-4">
                &copy; 2025 BloodFlower. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>