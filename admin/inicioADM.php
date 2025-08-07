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
    <title>Painel Admin | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #8b0000 !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 44px;
            margin-right: 10px;
        }

        h1 {
            color: #8b0000;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .btn-admin {
            background-color: #8b0000;
            color: #fff;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-admin:hover {
            background-color: #660000;
        }

        .table thead {
            background-color: #8b0000;
            color: white;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="inicioADM.php">
            <img src="../imagens/LogoBloodFlower.png" alt="Logo">
            BloodFlower
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active fw-bold text-danger" href="inicioADM.php"><i class="bi bi-box"></i> Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="pedidos.php"><i class="bi bi-bag-check"></i> Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="avaliacoes.php"><i class="bi bi-star"></i> Avaliações</a></li>
                <li class="nav-item"><a class="nav-link" href="usuarios.php"><i class="bi bi-people"></i> Usuários</a></li>
                <li class="nav-item"><a class="nav-link" href="enderecos.php"><i class="bi bi-geo-alt"></i> Endereços</a></li>
                <li class="nav-item"><a class="nav-link" href="marcas.php"><i class="bi bi-tags"></i> Marcas</a></li>
                <li class="nav-item"><a class="nav-link" href="categorias.php"><i class="bi bi-folder"></i> Categorias</a></li>
            </ul>
            <a href="../logoff.php" class="btn btn-outline-dark"><i class="bi bi-box-arrow-right"></i> Sair</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Produtos</h1>
        <a href="formProduto.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Produto</a>
    </div>

    <?php
    $sql = "SELECT p.id, p.nome, p.preco, p.descricao, p.estoque,
                   c.nome AS categoria_nome, m.nome AS marca_nome
            FROM produtos p
            JOIN categorias c ON p.categoria_id = c.id_categoria
            JOIN marca m ON p.marca_id = m.id_marca";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-hover align-middle'>";
        echo "<thead><tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Descrição</th>
                <th>Estoque</th>
                <th>Categoria</th>
                <th>Marca</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
            echo "<td>{$row['descricao']}</td>";
            echo "<td>{$row['estoque']}</td>";
            echo "<td>{$row['categoria_nome']}</td>";
            echo "<td>{$row['marca_nome']}</td>";
            echo "<td class='text-center'>
                    <a href='formEditProduto.php?id_produto={$row['id']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
            echo "<td class='text-center'>
                    <a href='excluirProduto.php?id={$row['id']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
