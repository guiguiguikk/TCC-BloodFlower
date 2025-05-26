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
    <title>Admin - Bloodfloewr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            padding: 40px;
        }

        .container-admin {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        h1 {
            color: #dc3545;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            margin-top: 20px;
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
    </style>
</head>
<body>

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
                        <a href='excluirProduto.php?id=" . $row['id'] . "'>
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
        <a href="cadProduto.html" class="btn btn-admin">Novo Produto</a>
        <a href="logoff.php" class="btn btn-outline-dark">Sair</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
