<?php
include("conexao.php");
session_start();

// Filtro de categoria se existir

$categoriaAtual = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;
// Filtro de busca se existir
$busca = isset($_GET['busca']) ? mysqli_real_escape_string($conn, $_GET['busca']) : '';

// Monta a query com filtros
$sql = "SELECT * FROM produtos";

if ($categoriaAtual > 0) {
    $sql .= " WHERE categoria_id = $categoriaAtual";
} elseif ($busca) {
    $sql .= " WHERE nome LIKE '%$busca%' OR descricao LIKE '%$busca%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            color: #dc3545 !important;
            letter-spacing: 1px;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 0 0 transparent;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transform: translateY(-4px);
        }

        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            width: 100%;
            height: 220px;
            object-fit: contain;
            background-color: #f1f1f1; /* fundo neutro para imagens menores */
            padding: 10px;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
        }

        .card-title {
            font-size: 1rem;
            color: #333;
            min-height: 3rem;
            margin-bottom: 10px;
        }

        .price {
            font-weight: 600;
            color: #28a745;
        }

        .nav-link.active {
            font-weight: bold;
            color: #dc3545 !important;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">BloodFlower</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavCliente">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavCliente">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $categoriaAtual == '0' ? 'active' : '' ?>" href="index.php">Todos os Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $categoriaAtual == '1' ? 'active' : '' ?>" href="index.php?categoria=1">Camisetas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $categoriaAtual == '2' ? 'active' : '' ?>" href="index.php?categoria=2">Calças</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $categoriaAtual == '3' ? 'active' : '' ?>" href="index.php?categoria=3">Moletons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $categoriaAtual == '4' ? 'active' : '' ?>" href="index.php?categoria=4">Acessórios</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <?php if (!isset($_SESSION['email'])) { ?>
                    <a href="entrar.php" class="btn btn-outline-dark btn-sm">Entrar</a>
                <?php } else { ?>
                    <a href="perfil.php" class="text-dark" title="Meu Perfil">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                <?php } ?>
                <a href="carrinho.php" class="text-dark" title="Carrinho">
                    <i class="bi bi-cart3 fs-4"></i>
                </a>
                <?php if (isset($_SESSION['email'])) { ?>
                <a href="logoff.php" class="btn btn-outline-dark btn-sm">Sair</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<!-- CATÁLOGO -->
<div class="container py-5">

    <div class="text-center mb-4">
        <h1 class="text-secondary">Bem-vindo ao BloodFlower</h1>
        <p class="text-muted">Explore nossos produtos e faça seu pedido!</p>
    </div>

    <div class="text-center mb-5">
        <form method="GET" action="index.php" class="d-flex justify-content-center">
            <div class="input-group w-50">
                <input 
                    type="text" 
                    name="busca" 
                    class="form-control form-control-lg rounded-pill ps-4" 
                    placeholder="Pesquisar produtos..." 
                    aria-label="Pesquisar"
                    style="border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <button class="btn btn-danger rounded-pill ms-2 px-4" type="submit">Buscar</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0) {
            while ($produto = mysqli_fetch_assoc($result)) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <a href="detalhes.php?id=<?= $produto['id']; ?>" class="text-decoration-none">
                            <img src="imagens/<?= htmlspecialchars($produto['imagem']); ?>" class="card-img-top" alt="<?= htmlspecialchars($produto['nome']); ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($produto['nome']); ?></h5>
                                <p class="price">R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></p>
                            </div>
                        </a>
                    </div>
                </div>
        <?php } 
        } else {
            echo "<p class='text-center text-muted'>Nenhum produto encontrado.</p>";
        } ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
