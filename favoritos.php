<?php 
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include("conexao.php");

$id_usuario = $_SESSION['id'];

// buscar os favoritos do usuário
$sql = "SELECT * FROM favorito WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "INSERT INTO favorito (usuario_id) VALUES ($id_usuario)");
    $id_favorito = mysqli_insert_id($conn);
} else {
    $favorito = mysqli_fetch_assoc($result);
    $id_favorito = $favorito['id_favorito'];
}

// buscar os itens favoritos
$sql_itens = "SELECT * FROM item_favorito WHERE favorito_id = $id_favorito";
$itens = mysqli_query($conn, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Favoritos | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .cart-img {
            width: 90px;
            height: auto;
            border-radius: 10px;
        }
        .card-fav {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .empty-message {
            text-align: center;
            padding: 60px 0;
            font-size: 1.2rem;
            color: #6c757d;
        }
        .btn-outline-danger:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand text-danger fw-bold" href="index.php">BloodFlower</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="perfil.php" class="text-dark" title="Perfil"><i class="bi bi-person-circle fs-4"></i></a>
            <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
            <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart3 fs-4"></i></a>
            <a href="logoff.php" class="btn btn-outline-danger btn-sm">Sair</a>
        </div>
    </div>
</nav>

<!-- FAVORITOS -->
<div class="container py-5">
    <h2 class="mb-4 text-danger">Meus Favoritos</h2>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <?php 
            if (mysqli_num_rows($itens) > 0) {
                while ($item = mysqli_fetch_assoc($itens)) {
                    $produto_id = $item['produto_id'];
                    $prod_result = mysqli_query($conn, "SELECT * FROM produtos WHERE id = $produto_id");
                    $produto = mysqli_fetch_assoc($prod_result);
                    
            ?>
            <div class="card-fav d-flex align-items-center">
                <img src="imagens/<?php echo $produto['imagem']; ?>" class="cart-img me-4" alt="Imagem do Produto">
                <div class="flex-grow-1">
                    <h5 class="mb-1"><?php echo $produto['nome']; ?></h5>
                    <p class="mb-2 text-muted">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    <div class="d-flex gap-2">
                        <a href="detalhes.php?id=<?php echo $produto_id; ?>" class="btn btn-outline-secondary btn-sm">Ver Produto</a>
                        <a href="adicionar_carrinho.php?produto_id=<?php echo $produto_id; ?>" class="btn btn-sm btn-outline-success">Adicionar ao Carrinho</a>
                    </div>
                </div>
                <div class="text-end ms-3">
                    <a href="removerFavorito.php?produto_id=<?php echo $produto_id; ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<div class='empty-message'>Você ainda não adicionou nenhum produto aos seus favoritos.</div>";
            } 
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
