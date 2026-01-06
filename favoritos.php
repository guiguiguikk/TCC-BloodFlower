<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include("conexao.php");

$id_usuario = $_SESSION['id'];

$sql = "SELECT * FROM favorito WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "INSERT INTO favorito (usuario_id) VALUES ($id_usuario)");
    $id_favorito = mysqli_insert_id($conn);
} else {
    $favorito = mysqli_fetch_assoc($result);
    $id_favorito = $favorito['id_favorito'];
}

$sql_itens = "SELECT * FROM item_favorito WHERE favorito_id = $id_favorito";
$itens = mysqli_query($conn, $sql_itens);

if (!$itens) {
    die("Erro ao buscar itens favoritos: " . mysqli_error($conn));
}



?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Favoritos | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #fdfdfd;
            font-family: 'Rubik', sans-serif;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            height: 48px;
            margin-right: 10px;
        }

        .navbar-brand {
            font-weight: bold;
            color: #8b0000 !important;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: #555 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #8b0000 !important;
        }

        .card-fav {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .card-fav img {
            width: 100px;
            height: auto;
            border-radius: 12px;
            background-color: #f5f5f5;
            padding: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.875rem;
        }

        .empty-message {
            text-align: center;
            padding: 80px 20px;
            color: #888;
        }

        .empty-message i {
            font-size: 3rem;
            color: #ccc;
        }

        .empty-message p {
            margin-top: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

    <!-- NAVBAR igual index.php -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower">
                BloodFlower
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavCliente">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavCliente">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Todos</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=1">Camisetas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=2">Calças</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=3">Moletons</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=4">Acessórios</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="perfil.php" class="text-dark" title="Perfil"><i class="bi bi-person-circle fs-4"></i></a>
                    <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart fs-4"></i></a>
                    <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
                    <a href="logoff.php" class="text-dark" title="Sair"><i class="bi bi-box-arrow-right fs-4"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Espaço da navbar fixa -->
    <div style="height: 90px;"></div>

    <!-- CONTEÚDO -->
    <div class="container py-5">
        <h2 class="mb-4 text-danger">Meus Favoritos</h2>
        <?php if (isset($_SESSION['mensagem_favorito'])): ?>
            <div class="alert alert-<?= $_SESSION['mensagem_favorito']['tipo']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensagem_favorito']['texto']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['mensagem_favorito']);
        endif; ?>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <?php
                if (mysqli_num_rows($itens) > 0) {
                    while ($item = mysqli_fetch_assoc($itens)) {
                        $produto_id = $item['produto_id'];

                        // Busca o produto favorito
                        $prod_result = mysqli_query($conn, "SELECT * FROM produtos WHERE id = $produto_id");
                        if (!$prod_result) {
                            die("Erro ao buscar produto: " . mysqli_error($conn));
                        }

                        $produto = mysqli_fetch_assoc($prod_result);
                        if (!$produto) {
                            continue; // Se o produto não existir, pula para o próximo
                        }

                        // Verifica se o produto está no carrinho
                        $check_produto_carrinho = mysqli_query($conn, "SELECT * FROM itens_carrinho WHERE produto_id = $produto_id AND carrinho_id IN (SELECT id_carrinho FROM carrinhos WHERE usuario_id = $id_usuario)");
                        $no_carrinho = (mysqli_num_rows($check_produto_carrinho) > 0);
                ?>

                        <div class="card-fav">
                            <img src="imagens/<?= $produto['imagem']; ?>" alt="<?= $produto['nome']; ?>">
                            <div class="flex-grow-1">
                                <h5 class="mb-1"><?= $produto['nome']; ?></h5>
                                <p class="mb-2 text-muted">R$ <?= number_format($produto['preco_desconto'] < $produto['preco'] && $produto['preco_desconto'] > 0 ? $produto['preco_desconto'] : $produto['preco'], 2, ',', '.'); ?></p>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="detalhes.php?id=<?= $produto_id; ?>" class="btn btn-outline-secondary btn-sm">Ver Produto</a>

                                    <?php if ($no_carrinho): ?>
                                        <form method="POST" action="removerCarrinho.php" class="d-inline">
                                            <input type="hidden" name="produto_id" value="<?= $produto_id; ?>">
                                            <input type="hidden" name="vem_de" value="favoritos">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover do Carrinho</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="adicionar_carrinho.php" class="d-inline">
                                            <input type="hidden" name="produto_id" value="<?= $produto_id; ?>">
                                            <input type="hidden" name="vem_de" value="favoritos">
                                            <button type="submit" class="btn btn-sm btn-danger">Adicionar ao Carrinho</button>
                                        </form>
                                    <?php endif; ?>

                                    <form method="POST" action="removerFavorito.php" class="d-inline">
                                        <input type="hidden" name="produto_id" value="<?= $produto_id; ?>">
                                        <input type="hidden" name="vem_de" value="favoritos">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                <?php
                    } // fim do while
                } else {
                    echo "
                            <div class='empty-message'>
                                <i class='bi bi-heartbreak'></i>
                                <p>Você ainda não adicionou nenhum produto aos favoritos.</p>
                            </div>";
                }
                ?>

            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>