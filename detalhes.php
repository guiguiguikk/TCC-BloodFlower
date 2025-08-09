<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

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

//verificação para ver se o item ja está nos favoritos
$favorito = "SELECT * FROM favorito WHERE usuario_id = " . $_SESSION['id'];
$result_favorito = mysqli_query($conn, $favorito);

$id_favorito = mysqli_fetch_assoc($result_favorito)['id_favorito'] ?? null;


$sql_check_favorito = "SELECT * FROM item_favorito WHERE favorito_id = " . $id_favorito . " AND produto_id = " . $produto['id'];
$result_check_favorito = mysqli_query($conn, $sql_check_favorito);
if (!$result_check_favorito) {
    echo "Erro ao verificar os favoritos: " . mysqli_error($conn);
    exit;
}

//verificaçao para ver se o item ja está no carrinho
$carrinho = "SELECT * FROM carrinhos WHERE usuario_id = " . $_SESSION['id'];
$result_carrinho = mysqli_query($conn, $carrinho);

$id_carrinho = mysqli_fetch_assoc($result_carrinho)['id_carrinho'] ?? null;

$sql_check_carrinho = "SELECT * FROM itens_carrinho WHERE carrinho_id = " . $id_carrinho . " AND produto_id = " . $produto['id'];
$result_check_carrinho = mysqli_query($conn, $sql_check_carrinho);
if (!$result_check_carrinho) {
    echo "Erro ao verificar o carrinho: " . mysqli_error($conn);
    exit;
}
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

        /* Cards da recomendação */
        .carousel .card {
            height: 320px;
            /* Altura fixa para todos os cards */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Imagens dos cards */
        .carousel .card img {
            height: 180px;
            /* altura fixa para imagem */
            object-fit: contain;
            /* preserva proporção sem cortar */
            width: 100%;
            border-radius: 8px 8px 0 0;
            background-color: #fff;
            /* fundo branco para contrastar */
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
                    <?php if (isset($result_check_carrinho) && mysqli_num_rows($result_check_carrinho) > 0): ?>
                        <form action="removerCarrinho.php" method="post">
                            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                            <input type="hidden" name="vem_de" value="detalhes"> <!-- de onde veio -->
                            <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle me-2"></i> Já no Carrinho</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="adicionar_carrinho.php">
                            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                            <input type="hidden" name="vem_de" value="detalhes"> <!-- de onde veio -->
                            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-cart-plus me-2"></i> Adicionar ao Carrinho</button>
                        </form>
                    <?php endif; ?>
                    <?php if (isset($result_check_favorito) && mysqli_num_rows($result_check_favorito) > 0): ?>
                        <form method="POST" action="removerFavorito.php">
                            <input type="hidden" name="vem_de" value="detalhes"> <!-- de onde veio -->
                            <input type="hidden" name="produto_id" value="<?= htmlspecialchars($produto['id']) ?>">
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-heart-fill me-2"></i> Remover dos Favoritos
                            </button>
                        </form>
                    <?php else: ?>

                        <form method="POST" action="add_favorito.php">
                            <input type="hidden" name="vem_de" value="detalhes"> <!-- de onde veio -->
                            <input type="hidden" name="produto_id" value="<?= htmlspecialchars($produto['id']) ?>">
                            <button type="submit" class="btn btn-outline-dark w-100">
                                <i class="bi bi-heart me-2"></i> Favoritar
                            </button>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php
    // Consulta recomendada: produtos da mesma categoria ou marca, menos o produto atual
    $categoria_id = $produto['categoria_id'];
    $marca_id = $produto['marca_id'];
    $produto_id = $produto['id'];

    $sql_recomendados = "SELECT * FROM produtos 
    WHERE id != $produto_id 
    AND (categoria_id = $categoria_id OR marca_id = $marca_id)
    LIMIT 10";

    $result_recomendados = mysqli_query($conn, $sql_recomendados);

    if (mysqli_num_rows($result_recomendados) > 0):
    ?>
        <div class="container mt-5">
            <h3 class="mb-4">Você pode gostar também</h3>
            <div id="carouselRecomendados" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $count = 0;
                    // Cada slide do carrossel vai ter até 4 produtos (para desktop)
                    // Vamos agrupar produtos em "slides"
                    $produtos_por_slide = 4;
                    $produtos = [];
                    while ($row = mysqli_fetch_assoc($result_recomendados)) {
                        $produtos[] = $row;
                    }

                    $total = count($produtos);
                    $slides = ceil($total / $produtos_por_slide);

                    for ($i = 0; $i < $slides; $i++):
                    ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <div class="row">
                                <?php
                                for ($j = 0; $j < $produtos_por_slide; $j++):
                                    $index = $i * $produtos_por_slide + $j;
                                    if ($index >= $total) break;
                                    $p = $produtos[$index];
                                ?>
                                    <div class="col-6 col-md-3">
                                        <div class="card">
                                            <img src="imagens/<?= htmlspecialchars($p['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nome']) ?>">
                                            <div class="card-body">
                                                <h6 class="card-title"><?= htmlspecialchars($p['nome']) ?></h6>
                                                <p class="card-text text-danger">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                                                <a href="detalhes.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary w-100">Ver Produto</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselRecomendados" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselRecomendados" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </div>
    <?php
    endif;
    ?>

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