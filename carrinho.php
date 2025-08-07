<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include("conexao.php");

$id_usuario = $_SESSION["id"];

$sql = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)");
    $id_carrinho = mysqli_insert_id($conn);
} else {
    $carrinho = mysqli_fetch_assoc($result);
    $id_carrinho = $carrinho['id_carrinho'];
}

$sql_itens = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho";
$itens = mysqli_query($conn, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho - BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f8f8;
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

        .cart-title {
            font-weight: bold;
            color: #8b0000;
        }

        .produto-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .produto-card img {
            width: 100px;
            height: auto;
            border-radius: 10px;
            object-fit: contain;
            background: #f2f2f2;
            padding: 5px;
        }

        .resumo-box {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 90px;
        }

        .btn-w100 {
            width: 100%;
        }

        .empty-cart {
            text-align: center;
            color: #888;
            margin-top: 80px;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #ccc;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
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

    <!-- Espaço da navbar fixa -->
    <div style="height: 90px;"></div>

    <!-- CONTEÚDO -->
    <div class="container py-4">
        <h2 class="cart-title mb-4">Seu Carrinho</h2>
        <?php if (isset($_SESSION['mensagem_carrinho'])): ?>
            <div class="alert alert-<?= $_SESSION['mensagem_carrinho']['tipo']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensagem_carrinho']['texto']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
            <?php unset($_SESSION['mensagem_carrinho']); ?>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <?php
                $total = 0;
                if (mysqli_num_rows($itens) > 0) {
                    while ($item = mysqli_fetch_assoc($itens)) {
                        $produto_id = $item['produto_id'];
                        $qtd = $item['quantidade'];
                        $prod_result = mysqli_query($conn, "SELECT * FROM produtos WHERE id = $produto_id");
                        $produto = mysqli_fetch_assoc($prod_result);

                        $subtotal = $produto['preco'] * $qtd;
                        $total += $subtotal;
                ?>
                        <div class="produto-card">
                            <img src="imagens/<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                            <div class="flex-grow-1">
                                <h5><?= $produto['nome'] ?></h5>
                                <p class="mb-1 text-muted">Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                                <form method="POST" action="atualizarQtd.php" class="d-flex align-items-center mt-2">
                                    <input type="hidden" name="carrinho_id" value="<?= $id_carrinho ?>">
                                    <input type="hidden" name="produto_id" value="<?= $produto_id ?>">
                                    <input type="number" name="quantidade" value="<?= $qtd ?>" min="1" class="form-control form-control-sm me-2" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-outline-success">Atualizar</button>
                                </form>
                            </div>
                            <div class="text-end">
                                <p class="fw-semibold text-success">Subtotal:<br> R$ <?= number_format($subtotal, 2, ',', '.') ?></p>
                                <a href="removerCarrinho.php?produto_id=<?= $produto_id ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="empty-cart">
                        <i class="bi bi-cart-x"></i>
                        <p class="mt-3">Seu carrinho está vazio.</p>
                      </div>';
                }
                ?>
            </div>

            <!-- RESUMO -->
            <div class="col-lg-4">
                <div class="resumo-box">
                    <h4 class="mb-4">Resumo do Pedido</h4>
                    <p class="d-flex justify-content-between">
                        <span>Total:</span>
                        <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong>
                    </p>
                    <?php if ($total > 0): ?>
                        <a href="pagamento.php" class="btn btn-dark btn-w100 mt-3">Finalizar Compra</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>