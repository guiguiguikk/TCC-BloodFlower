<?php
// ARQUIVO: pedido_confirmado.php
session_start();
include("conexao.php");

if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
$pedido_id = $_GET['pedido'] ?? 0;

// Consulta apenas para exibir na tela (Navbar, etc)
$sql_user_info = "SELECT pg.metodo_pagamento
 FROM pedidos p 
 JOIN pagamentos pg ON p.id = pg.id_pedido 
 WHERE p.id = $pedido_id";

$res_user = mysqli_query($conn, $sql_user_info);
$dados_pedido = mysqli_fetch_assoc($res_user);
$metodo_pagamento = $dados_pedido['metodo_pagamento'] ?? '';

// --- AQUI NÃO TEM MAIS CÓDIGO DO DOMPDF ---
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedido Confirmado | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Rubik', sans-serif; }
        .navbar { background-color: rgba(255, 255, 255, 0.95); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); }
        .navbar-brand { color: #8b0000 !important; font-weight: bold; font-size: 1.6rem; }
        .confirmation-box { background-color: #fff; border-radius: 12px; padding: 40px; max-width: 600px; margin: 80px auto; box-shadow: 0 0 20px rgba(0, 0, 0, 0.05); text-align: center; }
        .confirmation-box i { font-size: 4rem; color: #28a745; }
        .confirmation-box h2 { margin-top: 20px; font-weight: bold; color: #8b0000; }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">BloodFlower</a>
        </div>
    </nav>

    <div class="confirmation-box">
        <i class="bi bi-check-circle-fill"></i>
        <h2>Pedido Confirmado!</h2>
        <p>Seu pedido <strong>#<?= htmlspecialchars($pedido_id) ?></strong> foi realizado com sucesso.</p>
        
        <?php if($metodo_pagamento == 'boleto'): ?>
            <div class="alert alert-warning mt-3">
                <p>O seu boleto está sendo gerado...</p>
                <small>Se o download não iniciar, <a href="gerar_boleto.php?pedido=<?= $pedido_id ?>" target="_blank">clique aqui</a>.</small>
            </div>
        <?php else: ?>
            <p>Você pode acompanhar o status na sua área de pedidos.</p>
        <?php endif; ?>

        <a href="index.php" class="btn btn-outline-danger mt-4">Voltar para a Loja</a>
    </div>

    <?php if($metodo_pagamento == 'boleto'): ?>
    <script>
        // Espera a página carregar e chama o outro arquivo
        window.onload = function() {
            setTimeout(function() {
                window.location.href = 'gerar_boleto.php?pedido=<?= $pedido_id ?>';
            }, 1500); // Espera 1.5 segundos para dar tempo do usuário ver a tela
        };
    </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>