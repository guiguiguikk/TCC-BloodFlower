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
    <title>Bloodflower | Marcas</title>
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

        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            color: #570210 !important;
            letter-spacing: 1px;
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

        .btn-admin {
            background-color: #570210;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-admin:hover {
            background-color: #3e010c;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="inicioADM.php">BloodFlower</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="inicioADM.php"><i class="bi bi-box"></i> Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="usuarios.php"><i class="bi bi-people"></i> Usuários</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enderecos.php"><i class="bi bi-geo-alt"></i> Endereços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-danger" href="marcas.php"><i class="bi bi-tags"></i> Marcas</a>
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Marcas</h1>
        <a href="cadUsuario.php" class="btn btn-admin">
            <i class="bi bi-plus-lg"></i> Nova Marca
        </a>
    </div>

    <?php
    $sql = "SELECT * FROM marca";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-hover align-middle'>";
        echo "<thead><tr>";
        echo "<th>ID</th><th>Marca</th><th class='text-center' colspan='2'>Ações</th>";
        echo "</tr></thead><tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id_marca']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td class='text-center'>
                    <a href='formEditMarca.php?id_usuario={$row['id_marca']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
            echo "<td class='text-center'>
                    <a href='excluirMarca.php?id={$row['id_marca']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-muted text-center mt-4'>Nenhum usuário cadastrado.</p>";
    }
    ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
