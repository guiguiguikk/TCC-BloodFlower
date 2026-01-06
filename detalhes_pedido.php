<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$id_pedido = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Verifica se o pedido pertence ao usuário
$sql_pedido = "SELECT * FROM pedidos WHERE id = $id_pedido AND id_usuario = $id_usuario";
$result_pedido = mysqli_query($conn, $sql_pedido);

if (mysqli_num_rows($result_pedido) == 0) {
    echo "<p class='text-center mt-5'>Pedido não encontrado ou acesso não autorizado.</p>";
    exit;
}

$pedido = mysqli_fetch_assoc($result_pedido);

// Pega os itens do pedido
$sql_itens = "
    SELECT ip.*, p.nome, p.imagem, t.nome as tamanho_nome
    FROM itens_pedido ip 
    JOIN produtos p ON ip.id_produto = p.id 
    JOIN tamanhos t ON ip.tamanho = t.id
    WHERE ip.id_pedido = $id_pedido
";
$result_itens = mysqli_query($conn, $sql_itens);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido - BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand img {
            height: 45px;
            margin-right: 10px;
        }

        .pedido-info {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .produto-item {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }

        .produto-item img {
            width: 80px;
            height: auto;
            border-radius: 8px;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 30px 0;
            text-align: center;
            color: #888;
            margin-top: 100px;
        }

        .status-badge {
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower">
            BloodFlower
        </a>
        <div class="d-flex gap-3 align-items-center ms-auto">
            <a href="perfil.php" class="text-dark"><i class="bi bi-person-circle fs-4"></i></a>
            <a href="carrinho.php" class="text-dark"><i class="bi bi-cart fs-4"></i></a>
            <a href="favoritos.php" class="text-dark"><i class="bi bi-heart fs-4"></i></a>
            <a href="logoff.php" class="text-dark"><i class="bi bi-box-arrow-right fs-4"></i></a>
        </div>
    </div>
</nav>

<div style="height: 80px;"></div>

<!-- CONTEÚDO -->
<div class="container mb-5">
    <div class="pedido-info">
        <h4 class="mb-3 text-danger">Pedido #<?= $pedido['id'] ?></h4>
        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></p>
        <p><strong>Status:</strong> 
            <?php
            $status = $pedido['status'];
            $badge = "secondary";
            $icon = "clock";

            switch ($status) {
                case 'Aguardando':
                    $badge = "warning";
                    $icon = "hourglass-split";
                    break;
                case 'Enviado':
                    $badge = "info";
                    $icon = "truck";
                    break;
                case 'Entregue':
                    $badge = "success";
                    $icon = "check-circle";
                    break;
                case 'Cancelado':
                    $badge = "danger";
                    $icon = "x-circle";
                    break;
            }

            echo "<span class='badge bg-$badge status-badge'><i class='bi bi-$icon me-1'></i> $status</span>";
            ?>
        </p>
        <p><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.') ?></p>
    </div>

    <h5 class="mb-3">Itens do Pedido</h5>
    <?php while ($item = mysqli_fetch_assoc($result_itens)) { ?>
        <div class="produto-item d-flex align-items-center">
            <img src="imagens/<?= $item['imagem'] ?>" alt="<?= $item['nome'] ?>" class="me-3">
            <div class="flex-grow-1">
                <h6 class="mb-1"><?= $item['nome'] ?></h6>
                <p class="mb-0 text-muted">Quantidade: <?= $item['quantidade'] ?> | Preço: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
                <p class="mb-0 text-muted">Tamanho: <?= $item['tamanho_nome'] ?></p>
            </div>
            <div class="text-end">
                <p class="mb-0 fw-bold">Subtotal: R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></p>
            </div>
        </div>
    <?php } ?>

    <a href="perfil.php?secao=pedidos" class="btn btn-outline-secondary mt-4"><i class="bi bi-arrow-left"></i> Voltar aos pedidos</a>
</div>

<!-- FOOTER -->
<footer class="text-center">
    <div class="container">
        <p class="mb-0">&copy; <?= date("Y") ?> BloodFlower - Todos os direitos reservados.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

