<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include("conexao.php");

$id_usuario = $_SESSION["id"];

// Busca ou cria o carrinho do usuário
$sql = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)");
    $id_carrinho = mysqli_insert_id($conn);
} else {
    $carrinho = mysqli_fetch_assoc($result);
    $id_carrinho = $carrinho['id_carrinho'];
}

$sql_itens = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho";
$itens = mysqli_query($conn, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho | BloodFlower</title>
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
            <a href="perfil.php" class="text-dark" title="Perfil"><i class="bi bi-person-circle fs-4"></i></a>
            <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
            <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart3 fs-4"></i></a>
            <a href="logoff.php" class="btn btn-outline-danger btn-sm">Sair</a>
        </div>
    </div>
</nav>

<!-- CARRINHO -->
<div class="container py-5">
    <h2 class="mb-4">Seu Carrinho</h2>
    <div class="row g-4">
        <div class="col-lg-8">
            <?php 
            $total = 0;
            if (mysqli_num_rows($itens) > 0) {
                while ($item = mysqli_fetch_assoc($itens)) {
                    $produto_id = $item['produto_id'];
                    $qtd = $item['quantidade'];
                    $prod_result = mysqli_query($conn, "SELECT * FROM produtos WHERE id = $produto_id");
                    $produto = mysqli_fetch_assoc($prod_result);

                    $subtotal = $produto['preco'] * $qtd;
                    $total += $subtotal;
            ?>
            <div class="d-flex align-items-center border-bottom py-3">
                <img src="imagens/<?php echo $produto['imagem']; ?>" class="cart-img me-3" alt="">
                <div class="flex-grow-1">
                    <h5 class="mb-1"><?php echo $produto['nome']; ?></h5>
                    <p class="mb-1 text-muted">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    <div class="d-flex align-items-center">
                        <span class="me-2">Qtd:</span>
                        <form method="POST" action="atualizarQtd.php" class="d-flex align-items-center">
                            <input type="hidden" name="carrinho_id" value="<?php echo $id_carrinho; ?>">
                            <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
                            <input type="number" name="quantidade" value="<?php echo $qtd; ?>" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                            <button type="submit" class="btn btn-sm btn-outline-success">Atualizar</button>
                        </form>
                    </div>
                </div>
                <div class="text-end">
                    <p class="mb-2 fw-semibold text-success">Subtotal: R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></p>
                    <a href="removerCarrinho.php?produto_id=<?php echo $produto_id; ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<p class='text-muted'>Seu carrinho está vazio.</p>";
            } 
            ?>
        </div>

        <div class="col-lg-4">
            <div class="summary-box">
                <h4 class="mb-4">Resumo do Pedido</h4>
                <p class="d-flex justify-content-between">
                    <span>Total:</span>
                    <strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
                </p>
                <?php if ($total > 0): ?>
                    <a href="finalizar.php" class="btn btn-dark w-100 mt-3">Finalizar Compra</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
