<?php
include("conexao.php");
session_start();

$categoriaAtual = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;
$busca = isset($_GET['busca']) ? mysqli_real_escape_string($conn, $_GET['busca']) : '';

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
    <link rel="icon" href="imagens/LogoBloodFlower.png" type="image/png">

    <!-- Bootstrap & Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #fdfdfd;
            font-family: 'Rubik', sans-serif;
            color: #333;
        }

        /* NAVBAR */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
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
            margin: 0 5px;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #8b0000 !important;
        }

        /* BARRA DE BUSCA */
        .search-bar {
            max-width: 600px;
            margin: 40px auto 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            height: 250px;
            object-fit: contain;
            background: #f9f9f9;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 10px;
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .price {
            font-size: 1rem;
            color: #28a745;
            font-weight: 500;
        }

        /* FOOTER */
        footer {
            background: #f8f8f8;
            padding: 30px 0;
            font-size: 0.95rem;
            margin-top: 60px;
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
                <li class="nav-item"><a class="nav-link <?= $categoriaAtual == '0' ? 'active' : '' ?>" href="index.php">Todos</a></li>
                <li class="nav-item"><a class="nav-link <?= $categoriaAtual == '1' ? 'active' : '' ?>" href="index.php?categoria=1">Camisetas</a></li>
                <li class="nav-item"><a class="nav-link <?= $categoriaAtual == '2' ? 'active' : '' ?>" href="index.php?categoria=2">Calças</a></li>
                <li class="nav-item"><a class="nav-link <?= $categoriaAtual == '3' ? 'active' : '' ?>" href="index.php?categoria=3">Moletons</a></li>
                <li class="nav-item"><a class="nav-link <?= $categoriaAtual == '4' ? 'active' : '' ?>" href="index.php?categoria=4">Acessórios</a></li>
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

<!-- ESPAÇO EXTRA PELA NAVBAR FIXA -->
<div style="height: 90px;"></div>

<!-- BARRA DE BUSCA -->
<div class="search-bar px-3">
    <form method="GET" action="index.php" class="input-group">
        <input type="text" name="busca" class="form-control" placeholder="Pesquisar produtos...">
        <button class="btn btn-danger" type="submit">Buscar</button>
    </form>
</div>

<!-- PRODUTOS -->
<div class="container my-5">
    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0) {
            while ($produto = mysqli_fetch_assoc($result)) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <a href="detalhes.php?id=<?= $produto['id']; ?>" class="text-decoration-none text-dark">
                            <img src="imagens/<?= htmlspecialchars($produto['imagem']); ?>" class="card-img-top" alt="<?= htmlspecialchars($produto['nome']); ?>">
                            <div class="card-body">
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

<!-- FOOTER -->
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
                    <li><a href="#" class="text-muted text-decoration-none">Início</a></li>
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
