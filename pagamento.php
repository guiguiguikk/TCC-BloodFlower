<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include("conexao.php");

$id_usuario = $_SESSION["id"];

// Buscar endereços
$sql_enderecos = "SELECT * FROM enderecos WHERE usuario_id = $id_usuario";
$res_enderecos = mysqli_query($conn, $sql_enderecos);
$enderecos = [];
while ($e = mysqli_fetch_assoc($res_enderecos)) {
    $enderecos[] = $e;
}

// Buscar carrinho e itens
$sql_carrinho = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$carrinho_res = mysqli_query($conn, $sql_carrinho);
$carrinho = mysqli_fetch_assoc($carrinho_res);
$id_carrinho = $carrinho['id_carrinho'];

$sql_itens = "SELECT ic.*, p.nome, p.preco, p.imagem 
              FROM itens_carrinho ic
              JOIN produtos p ON ic.produto_id = p.id
              WHERE carrinho_id = $id_carrinho";
$res_itens = mysqli_query($conn, $sql_itens);

$total = 0;
$produtos = [];
while ($item = mysqli_fetch_assoc($res_itens)) {
    $subtotal = $item['preco'] * $item['quantidade'];
    $total += $subtotal;
    $produtos[] = $item;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Pagamento - BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f8f8;
            font-family: 'Rubik', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            height: 48px;
            margin-right: 10px;
        }

        .navbar-brand {
            font-weight: bold;
            color: #8b0000 !important;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: #555 !important;
            font-weight: 500;
            margin: 0 5px;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #8b0000 !important;
        }

        .pagamento-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .form-check-label img {
            width: 80px;
        }

        .btn-w100 {
            width: 100%;
        }

        .endereco-radio {
            cursor: pointer;
        }

        /* FOOTER */
        footer {
            background: #f8f8f8;
            padding: 30px 0;
            font-size: 0.95rem;
            margin-top: 60px;
        }

        footer h5 {
            color: #8b0000;
        }

        .footer-bottom {
            border-top: 1px solid #ddd;
            text-align: center;
            padding-top: 15px;
            color: #999;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower">
                BloodFlower
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavCliente">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="d-flex align-items-center gap-3">
                <?php if (!isset($_SESSION['email'])) { ?>
                    <a href="entrar.php" class="text-dark" title="Entrar"><i class="bi bi-box-arrow-in-right fs-4"></i></a>
                <?php } else { ?>
                    <a href="perfil.php" class="text-dark" title="Meu Perfil"><i class="bi bi-person-circle fs-4"></i></a>
                <?php } ?>
                <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart fs-4"></i></a>
                <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
                <?php if (isset($_SESSION['email'])) { ?>
                    <a href="logoff.php" class="text-dark" title="Sair"><i class="bi bi-box-arrow-right fs-4"></i></a>
                <?php } ?>
            </div>
        </div>
        </div>
    </nav>
    <div class="container mt-5 pt-5 ">
        <h2 class="text-center mb-4 text-danger"><i class="bi bi-credit-card"></i> Pagamento</h2>
        <div class="row g-4">
            <!-- PAGAMENTO -->
            <div class="col-md-6">
                <div class="pagamento-box">
                    <form action="processar_pagamento.php" method="POST">
                        <input type="hidden" name="valor_total" value="<?= $total ?>">

                        <h5 class="mb-3"><i class="bi bi-wallet2"></i> Forma de Pagamento</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="forma_pagamento" id="cartao" value="Cartão" checked>
                            <label class="form-check-label" for="cartao"><i class="bi bi-credit-card"></i> Cartão de Crédito</label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="forma_pagamento" id="pix" value="Pix">
                            <label class="form-check-label" for="pix"><i class="bi bi-upc-scan"></i> Pix</label>
                        </div>

                        <h5 class="mb-3"><i class="bi bi-geo-alt"></i> Endereço de Entrega</h5>
                        <?php if (count($enderecos) > 0): ?>
                            <?php foreach ($enderecos as $e): ?>
                                <div class="form-check mb-2 endereco-radio">
                                    <input class="form-check-input" type="radio" name="endereco_id" id="endereco<?= $e['id_endereco'] ?>" value="<?= $e['id_endereco'] ?>" <?= $e === $enderecos[0] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="endereco<?= $e['id_endereco'] ?>">
                                        <?= $e['rua'] ?>, <?= $e['numero'] ?> - <?= $e['cidade'] ?>/<?= $e['estado'] ?> - <?= $e['cep'] ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Nenhum endereço cadastrado.</p>
                        <?php endif; ?>

                        <button type="button" class="btn btn-outline-secondary mt-2" data-bs-toggle="modal" data-bs-target="#modalEndereco">
                            <i class="bi bi-plus-circle"></i> Cadastrar Novo Endereço
                        </button>

                        <button type="submit" class="btn btn-dark btn-w100 mt-4">
                            <i class="bi bi-bag-check-fill"></i> Confirmar Pagamento
                        </button>
                    </form>
                </div>
            </div>

            <!-- RESUMO -->
            <div class="col-md-6">
                <div class="pagamento-box">
                    <h5 class="mb-4"><i class="bi bi-receipt"></i> Resumo da Compra</h5>
                    <?php foreach ($produtos as $item): ?>
                        <div class="d-flex align-items-center mb-3">
                            <img src="imagens/<?= $item['imagem'] ?>" alt="<?= $item['nome'] ?>" width="60" class="me-3 rounded">
                            <div>
                                <strong><?= $item['nome'] ?></strong><br>
                                <?= $item['quantidade'] ?>x R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <h5>Total: R$ <?= number_format($total, 2, ',', '.') ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>BloodFlower</h5>
                    <p>Vista-se com originalidade e atitude. Roupas alternativas para quem quer se destacar.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Início</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Loja</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Contato</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contato</h5>
                    <p><i class="bi bi-envelope"></i> contato@bloodflower.com</p>
                    <p><i class="bi bi-instagram"></i> @bloodflower</p>
                </div>
            </div>
            <div class="footer-bottom mt-4">
                &copy; 2025 BloodFlower. Todos os direitos reservados.
            </div>
        </div>
        </footer>
        <!-- MODAL NOVO ENDEREÇO -->
        <div class="modal fade" id="modalEndereco" tabindex="-1" aria-labelledby="modalEnderecoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="cadastrar_endereco.php" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEnderecoLabel"><i class="bi bi-house-add"></i> Novo Endereço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="voltar_para_pagamento" value="1">
                        <div class="mb-2">
                            <label class="form-label">CEP</label>
                            <input type="text" class="form-control" name="cep" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Logradouro</label>
                            <input type="text" class="form-control" name="logradouro" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Cidade</label>
                            <input type="text" class="form-control" name="cidade" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Estado</label>
                            <input type="text" class="form-control" name="estado" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tipo (Casa, Trabalho...)</label>
                            <input type="text" class="form-control" name="tipo">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>