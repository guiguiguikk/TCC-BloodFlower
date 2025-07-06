<?php
session_start();
include("conexao.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM produtos WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Produto não encontrado.";
    exit;
}

$produto = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($produto['nome']); ?> - Detalhes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .img-produto {
            width: 100%;
            max-height: 450px;
            object-fit: contain;
            border-radius: 10px;
            background-color: #fff;
            padding: 15px;
        }

        .btn-custom {
            border-radius: 30px;
            padding: 10px 30px;
            font-size: 1.1rem;
        }

        .preco {
            color: #28a745;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .descricao {
            color: #555;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand text-danger fw-bold" href="index.php">BloodFlower</a>

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
                <a href="favoritos.php" class="text-dark" title="Favoritos">
                    <i class="bi bi-heart fs-4"></i>
                </a>
                <?php if (isset($_SESSION['email'])) { ?>
                <a href="logoff.php" class="btn btn-outline-dark btn-sm">Sair</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<!-- Conteúdo -->
<div class="container py-5">
    <div class="row g-5 align-items-start">
        <div class="col-md-6">
            <img src="imagens/<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="img-produto w-100">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($produto['nome']); ?></h2>
            <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            <p class="descricao mb-4"><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>

            <div class="d-flex flex-column flex-md-row gap-3">
                <form method="POST" action="adicionar_carrinho.php">
                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                    <button type="submit" class="btn btn-danger btn-custom w-100">
                        <i class="bi bi-cart-plus me-2"></i> Adicionar ao Carrinho
                    </button>
                </form>

                <form method="POST" action="add_favorito.php">
                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                    <button type="submit" class="btn btn-outline-dark btn-custom w-100">
                        <i class="bi bi-heart me-2"></i> Favoritar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
