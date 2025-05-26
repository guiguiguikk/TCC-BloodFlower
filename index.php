<?php
include("conexao.php");
session_start();

$sql = "SELECT * FROM produtos";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Bloodfloewr</title>
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
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transform: translateY(-4px);
        }

        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-title {
            font-size: 1rem;
            color: #333;
            min-height: 3rem;
        }

        .price {
            font-weight: 600;
            color: #28a745;
        }

        .btn-login {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BloodFlower</a>
        <div class="ms-auto d-flex gap-3 align-items-center">
    <?php if (!isset($_SESSION['email'])) { ?>
        <a href="entrar.php" class="btn btn-outline-dark btn-sm btn-login">Entrar</a>
    <?php } else { ?>
        <a href="perfil.php" class="text-dark" title="Meu Perfil">
            <i class="bi bi-person-circle fs-4"></i>
        </a>
    <?php } ?>
    <a href="carrinho.php" class="text-dark" title="Carrinho">
        <i class="bi bi-cart3 fs-4"></i>
    </a>
    <a href="logoff.php">sair</a>
</div>
            </a>
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
        <?php while ($produto = mysqli_fetch_assoc($result)) { ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <a href="detalhes.php?id=<?php echo $produto['id']; ?>" class="text-decoration-none">
                        <img src="imagens/<?php echo htmlspecialchars($produto['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                            <p class="price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
