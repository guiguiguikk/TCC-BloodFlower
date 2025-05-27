<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: index.php");
    exit;
}

include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Bloodflower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-admin {
            max-width: 1100px;
            margin: 80px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        h1 {
            color: #dc3545;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
        }

        .table th {
            background-color: #dc3545;
            color: white;
        }

        .table td img {
            width: 24px;
            height: 24px;
        }

        .actions a {
            margin: 0 5px;
        }

        .btn-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-admin {
            background-color: #dc3545;
            color: white;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 500;
        }

        .btn-admin:hover {
            background-color: #bb2d3b;
        }

        .no-produtos {
            text-align: center;
            color: #777;
            padding: 40px 0;
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
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="admin.php">BloodFlower</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="admin.php"><i class="bi bi-box"></i> Produtos</a>
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
                <?php if (!isset($_SESSION['email'])) { ?>
                    <a href="entrar.php" class="btn btn-outline-dark btn-sm">Entrar</a>
                <?php } else { ?>
                    <a href="perfil.php" class="text-dark" title="Meu Perfil">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                <?php } ?>
                <a href="logoff.php" class="btn btn-outline-dark">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </div>
        </div>
    </div>
</nav>


<div class="container-admin">
    <h1>Painel de Administração</h1>

    <div class="table-responsive">
        <?php
        $sql  = "SELECT * FROM produtos";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered align-middle'>";
            echo "<thead><tr>";
            echo "<th>ID</th>";
            echo "<th>Nome</th>";
            echo "<th>Preço</th>";
            echo "<th>Descrição</th>";
            echo "<th>Estoque</th>";
            echo "<th>Categoria</th>";
            echo "<th colspan='2' class='text-center'>Ações</th>";
            echo "</tr></thead><tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>R$ " . number_format($row["preco"], 2, ',', '.') . "</td>";
                echo "<td>" . $row["descricao"] . "</td>";
                echo "<td>" . $row["estoque"] . "</td>";
                echo "<td>" . $row["categoria_id"] . "</td>";
                echo "<td class='text-center actions'>
                        <a href='formEditProduto.php?id_produto=" . $row['id'] . "'>
                            <img src='imagens/editar2.png' alt='Editar'>
                        </a>
                      </td>";
                echo "<td class='text-center actions'>
                        <a href='excluirProduto.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                            <img src='imagens/lixo.png' alt='Excluir'>
                        </a>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p class='no-produtos'>Nenhum produto cadastrado.</p>";
        }
        ?>
    </div>

    <div class="btn-actions">
        <a href="cadProduto.html" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Produto</a>
  
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
