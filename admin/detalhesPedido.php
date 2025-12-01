<?php
session_start();
// Verificação de segurança básica
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: entrar.php");
    exit;
}

include("../conexao.php");

// Segurança: Cast para int para evitar SQL Injection
$id = isset($_GET['id_pedido']) ? (int)$_GET['id_pedido'] : 0;

// 1. Buscar dados do PEDIDO
$sql_pedido = "SELECT * FROM pedidos WHERE id = $id";
$result_pedido = mysqli_query($conn, $sql_pedido);

if (!$result_pedido || mysqli_num_rows($result_pedido) == 0) {
    die("Pedido não encontrado.");
}
$row_pedido = mysqli_fetch_assoc($result_pedido);

// 2. Buscar dados do USUÁRIO (Cliente)
$sql_usuario = "SELECT * FROM usuarios WHERE id_usuario =" . $row_pedido["id_usuario"];
$result_usuario = mysqli_query($conn, $sql_usuario);
$row_usuario = mysqli_fetch_assoc($result_usuario);

// 3. Buscar os ITENS do pedido
$sql_itens = "SELECT prod.nome AS Produto_nome, prod.imagem AS produto_imagem, i.preco AS item_preco, i.quantidade AS item_quantidade, i.subtotal AS item_subtotal 
              FROM itens_pedido i 
              JOIN produtos prod ON i.id_produto = prod.id 
              WHERE i.id_pedido = $id";
$result_itens = mysqli_query($conn, $sql_itens);

// Função auxiliar para formatar moeda (R$)
function formatarMoeda($valor) {
    return "R$ " . number_format($valor, 2, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalhes do Pedido #<?= $id ?> - BloodFlower</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9; /* Fundo levemente cinza */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Estilo dos Cards igual à imagem */
        .card-custom {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            background-color: #fff;
            margin-bottom: 20px;
        }

        .card-header-custom {
            background-color: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 15px 20px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-custom i {
            color: #8b0000; /* Azul Bootstrap */
        }

        /* Badge de Status */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            background-color: #d1e7dd;
            color: #0f5132;
        }

        /* Tabela */
        .table-custom th {
            font-weight: 500;
            color: #6c757d;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
        }
        .table-custom td {
            vertical-align: middle;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .produto-img {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #eee;
        }

        .total-highlight {
            font-size: 1.25rem;
            color: #8b0000;
            font-weight: bold;
        }

        .back-btn {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="inicioADM.php?secao=pedidos" class="btn btn-light border mb-2"><i class="bi bi-arrow-left"></i> Voltar</a>
            <h2 class="fw-bold mb-0">Pedido #<?= $id ?></h2>
            <small class="text-muted">Realizado em <?= date('d/m/Y \à\s H:i', strtotime($row_pedido["data_pedido"])) ?></small>
        </div>
        <div>
            <span class="status-badge"><?= htmlspecialchars($row_pedido['status']) ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-custom h-100">
                <div class="card-header-custom">
                    <i class="bi bi-person"></i> Informações do Cliente
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Nome:</span>
                        <span class="fw-medium"><?= htmlspecialchars($row_usuario['nome']) ?></span>
                    </div>
                    <hr class="my-2 text-muted" style="opacity: 0.1">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Email:</span>
                        <span class="fw-medium"><?= htmlspecialchars($row_usuario['email']) ?></span>
                    </div>
                    </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-custom h-100">
                <div class="card-header-custom">
                    <i class="bi bi-receipt"></i> Resumo do Pedido
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span><?= formatarMoeda($row_pedido['total']) ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total:</span>
                        <span class="total-highlight"><?= formatarMoeda($row_pedido['total']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <i class="bi bi-box-seam"></i> Itens do Pedido
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="padding-left: 20px;">Produto</th>
                                    <th class="text-end">Preço Unit.</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-end" style="padding-right: 20px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = mysqli_fetch_assoc($result_itens)): ?>
                                <tr>
                                    <td style="padding-left: 20px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php 
                                                $imgSrc = !empty($item['produto_imagem']) ? "../img/" . $item['produto_imagem'] : "https://via.placeholder.com/50";
                                            ?>
                                            <img src="<?= $imgSrc ?>" class="produto-img" alt="Prod">
                                            <span class="fw-medium"><?= htmlspecialchars($item['Produto_nome']) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-end"><?= formatarMoeda($item["item_preco"]) ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border"><?= $item['item_quantidade'] ?></span>
                                    </td>
                                    <td class="text-end fw-bold" style="padding-right: 20px;">
                                        <?= formatarMoeda($item['item_subtotal']) ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>