<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
$pedido_id = $_GET['pedido'] ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedido Confirmado | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Rubik', sans-serif;
        }

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

        .confirmation-box {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            max-width: 600px;
            margin: 80px auto;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            text-align: center;
        }

        .confirmation-box i {
            font-size: 4rem;
            color: #28a745;
        }

        .confirmation-box h2 {
            margin-top: 20px;
            font-weight: bold;
            color: #8b0000;
        }

        .confirmation-box p {
            margin-top: 15px;
            color: #555;
            font-size: 1.1rem;
        }

        .footer {
            background-color: #f1f1f1;
            padding: 30px 0;
            text-align: center;
            color: #888;
            margin-top: 100px;
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
                <a href="perfil.php" class="text-dark" title="Meu Perfil"><i class="bi bi-person-circle fs-4"></i></a>
                <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart fs-4"></i></a>
                <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
                <a href="logoff.php" class="text-dark" title="Sair"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Espaço para navbar fixa -->
<div style="height: 90px;"></div>

<!-- Confirmação -->
<div class="confirmation-box">
    <i class="bi bi-check-circle-fill"></i>
    <h2>Pedido Confirmado!</h2>
    <p>Seu pedido <strong>#<?= htmlspecialchars($pedido_id) ?></strong> foi realizado com sucesso.</p>
    <p>Você pode acompanhar o status na sua <a href="perfil.php?secao=pedidos">área de pedidos</a>.</p>
    <a href="index.php" class="btn btn-outline-danger mt-4">Voltar para a Loja</a>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; <?= date('Y') ?> BloodFlower - Todos os direitos reservados</p>
    </div>
</footer>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
