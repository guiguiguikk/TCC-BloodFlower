<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>BloodFlower | Pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .navbar-brand img {
            height: 48px;
            margin-right: 10px;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            color: #570210 !important;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }

        h1 {
            color: #570210;
            font-weight: 700;
            text-align: center;
            margin: 40px 0 20px;
        }

        .table thead {
            background-color: #570210;
            color: white;
        }

        .status {
            font-weight: bold;
        }

        .status.pago {
            color: green;
        }

        .status.pendente {
            color: orange;
        }

        .status.cancelado {
            color: red;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="inicioADM.php">
            <img src="../imagens/LogoBloodFlower.png" alt="Logo BloodFlower">
            BloodFlower
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="inicioADM.php"><i class="bi bi-box"></i> Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-danger" href="pedidos.php"><i class="bi bi-receipt"></i> Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="avaliacoes.php"><i class="bi bi-star"></i> Avaliações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="usuarios.php"><i class="bi bi-people"></i> Usuários</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enderecos.php"><i class="bi bi-geo-alt"></i> Endereços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="marcas.php"><i class="bi bi-tags"></i> Marcas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categorias.php"><i class="bi bi-folder"></i> Categorias</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <a href="../logoff.php" class="btn btn-outline-dark">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h1>Pedidos Realizados</h1>

    <?php
    $sql = "SELECT 
                p.id, 
                p.id_usuario, 
                p.data_pedido, 
                p.status AS status_pedido,
                p.total,
                u.nome AS nome_cliente,
                pg.metodo_pagamento AS forma_pagamento,
                pg.status AS status_pagamento
            FROM pedidos p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            LEFT JOIN pagamentos pg ON p.id = pg.id_pedido
            ORDER BY p.data_pedido DESC";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-hover align-middle'>";
        echo "<thead><tr>";
        echo "<th>ID</th><th>Cliente</th><th>Data</th><th>Status</th><th>Total</th><th>Pagamento</th><th>Status Pagamento</th><th>Ações</th>";
        echo "</tr></thead><tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nome_cliente']}</td>";
            echo "<td>" . date('d/m/Y H:i', strtotime($row['data_pedido'])) . "</td>";
            echo "<td>{$row['status_pedido']}</td>";
            echo "<td>R$ " . number_format($row['total'], 2, ',', '.') . "</td>";
            echo "<td>" . ($row['forma_pagamento'] ?? '-') . "</td>";
            echo "<td class='status " . strtolower($row['status_pagamento']) . "'>" . ($row['status_pagamento'] ?? '-') . "</td>";
                        echo "<td class='text-center'>
                    <a href='formEditPedido.php?id_pedido={$row['id']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-muted text-center mt-4'>Nenhum pedido encontrado.</p>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
