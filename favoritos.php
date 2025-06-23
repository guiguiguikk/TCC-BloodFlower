<?php
session_start();
include("conexao.php");
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_usuario = $_SESSION["id"];

$sql = "SELECT * FROM favoritos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    $create_favorites = "INSERT INTO favoritos (usuario_id) VALUES ($id_usuario)";
    mysqli_query($conn, $create_favorites);
    $id_favorito = mysqli_insert_id($conn);
}else {
    $id_favorito = mysqli_fetch_assoc($result)['id_favoritos'];
}

$favorito = mysqli_fetch_assoc($result);

$sql_favoritos = "SELECT * FROM itens_favoritos WHERE favoritos_id = $id_favorito";
$itens_favoritos = mysqli_query($conn, $sql_favoritos);
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
        .cart-img {
            width: 80px;
            height: auto;
            border-radius: 8px;
        }
        .summary-box {
            border-radius: 12px;
            background: #fff;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand text-danger fw-bold" href="index.php">BloodFlower</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="perfil.php" class="text-dark"><i class="bi bi-person-circle fs-4"></i></a>
            <a href="carrinho.php" class="text-dark"><i class="bi bi-cart3 fs-4"></i></a>
            <a href="logoff.php" class="btn btn-outline-danger btn-sm">Sair</a>
        </div>
    </div>
</nav>

<!-- CARRINHO -->
<div class="container py-5">
    <h2 class="mb-4">Seus Favoritos</h2>
    <div class="row g-4">
        <div class="col-lg-8">
            <?php 
            if (mysqli_num_rows($itens) > 0) {
                while ($item = mysqli_fetch_assoc($itens)) {
                    $produto_id = $item['produto_id'];
                    $prod_result = mysqli_query($conn, "SELECT * FROM produtos WHERE id = $produto_id");
                    $produto = mysqli_fetch_assoc($prod_result);

            ?>
            <div class="d-flex align-items-center border-bottom py-3">
                <img src="imagens/<?php echo $produto['imagem']; ?>" class="cart-img me-3" alt="">
                <div class="flex-grow-1">
                    <h5 class="mb-1"><?php echo $produto['nome']; ?></h5>
                    <p class="mb-1 text-muted">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    
                </div>
                <div class="text-end">
                    <p class="mb-2 fw-semibold text-success">Preço: R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></p>
                    <a href="removerFavorito.php?produto_id=<?php echo $produto_id; ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<p class='text-muted'>Seu carrinho está vazio.</p>";
            } 
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>