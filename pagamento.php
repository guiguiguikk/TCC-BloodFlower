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
            background: linear-gradient(180deg, #fafafa 0%, #f0f0f0 100%);
            font-family: 'Rubik', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .pagamento-box {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .pagamento-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .nav-pills .nav-link {
            color: #8b0000;
            border: 1px solid #8b0000;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-pills .nav-link.active {
            background-color: #8b0000;
            color: #fff;
        }

        .pagamento-titulo {
            border-left: 5px solid #8b0000;
            padding-left: 10px;
            margin-bottom: 25px;
            color: #8b0000;
            font-weight: 600;
        }

        .btn-dark {
            background-color: #8b0000;
            border: none;
            transition: background 0.2s ease;
        }

        .btn-dark:hover {
            background-color: #a40000;
        }

        .valor-total {
            font-size: 1.3rem;
            font-weight: 600;
            color: #8b0000;
        }

        .form-control:focus {
            border-color: #8b0000;
            box-shadow: 0 0 0 0.2rem rgba(139, 0, 0, 0.25);
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

        #modalEndereco .modal-content {
            animation: fadeInScale 0.3s ease;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        #modalEndereco .form-control {
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        #modalEndereco .form-control:focus {
            border-color: #8b0000;
            box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.15);
        }

        #modalEndereco label {
            color: #333;
        }

        #modalEndereco .btn-danger {
            background: linear-gradient(90deg, #8b0000, #a40000);
            border: none;
            transition: all 0.2s ease;
        }

        #modalEndereco .btn-danger:hover {
            background: linear-gradient(90deg, #a40000, #b00000);
            transform: scale(1.05);
        }

        .endereco-opcao {
            transition: all 0.2s ease-in-out;
            border-radius: 12px;
        }

        .endereco-opcao:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .form-check-input:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-dark:hover {
            background-color: #212529;
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower" height="48" class="me-2">
                BloodFlower
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="perfil.php" class="text-dark" title="Meu Perfil"><i class="bi bi-person-circle fs-4"></i></a>
                <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart fs-4"></i></a>
                <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
                <a href="logoff.php" class="text-dark" title="Sair"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="text-danger fw-bold"><i class="bi bi-credit-card"></i> Finalize Seu Pagamento</h2>
            <p class="text-muted">Revise suas informações e escolha sua forma de pagamento</p>
        </div>

        <div class="row g-4">
            <!-- PAGAMENTO -->
            <div class="col-md-6">
                <div class="pagamento-box">
                    <h5 class="pagamento-titulo"><i class="bi bi-wallet2"></i> Forma de Pagamento</h5>

                    <ul class="nav nav-pills mb-4 justify-content-center" id="paymentTabs" role="tablist">
                        <li class="nav-item me-2">
                            <button class="nav-link active" id="cartao-tab" data-bs-toggle="pill" data-bs-target="#cartao" type="button" role="tab">
                                <i class="bi bi-credit-card-2-front me-1"></i> Cartão
                            </button>
                        </li>
                        <li class="nav-item me-2">
                            <button class="nav-link" id="pix-tab" data-bs-toggle="pill" data-bs-target="#pix" type="button" role="tab">
                                <i class="bi bi-qr-code me-1"></i> Pix
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="boleto-tab" data-bs-toggle="pill" data-bs-target="#boleto" type="button" role="tab">
                                <i class="bi bi-receipt me-1"></i> Boleto
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="paymentTabsContent">
                        <!-- CARTÃO -->
                        <div class="tab-pane fade show active" id="cartao" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Nome no Cartão</label>
                                    <input type="text" class="form-control" placeholder="Ex: Gustavo Silva">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Número do Cartão</label>
                                    <input type="text" class="form-control" placeholder="**** **** **** 1234">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Validade</label>
                                    <input type="text" class="form-control" placeholder="MM/AA">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <!-- PIX -->
                        <div class="tab-pane fade text-center py-4" id="pix" role="tabpanel">
                            <p class="text-muted">Escaneie o QR Code abaixo para realizar o pagamento via Pix.</p>
                            <img src="imagens/qrcode.png" alt="QR Code Pix" class="img-fluid" width="200">
                            <p class="mt-3"><small>Chave Pix: contato@bloodflower.com</small></p>
                        </div>

                        <!-- BOLETO -->
                        <div class="tab-pane fade text-center py-4" id="boleto" role="tabpanel">
                            <p class="text-muted mb-3">Ao confirmar o pagamento, o boleto será gerado.</p>
                            <i class="bi bi-file-earmark-text fs-1 text-danger"></i>
                            <p class="mt-2">Clique em “Confirmar Pagamento” para gerar seu boleto bancário.</p>
                        </div>
                    </div>

                    <hr class="my-4">


                    <h5 class="pagamento-titulo mb-3 text-dark fw-bold d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill me-2 text-danger fs-4"></i> Endereço de Entrega
                    </h5>

                    <?php if (count($enderecos) > 0): ?>
                        <div class="endereco-lista">
                            <?php foreach ($enderecos as $e): ?>
                                <div class="card mb-3 shadow-sm border-0 endereco-opcao">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-3" type="radio" name="endereco_id"
                                                id="endereco<?= $e['id_endereco'] ?>"
                                                value="<?= $e['id_endereco'] ?>"
                                                <?= $e === $enderecos[0] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="endereco<?= $e['id_endereco'] ?>">
                                                <strong><?= $e['rua'] ?>, <?= $e['numero'] ?></strong><br>
                                                <small class="text-muted"><?= $e['bairro'] ?> - <?= $e['cidade'] ?>/<?= $e['estado'] ?> - <?= $e['cep'] ?></small>
                                            </label>
                                        </div>
                                        <i class="bi bi-house-door text-secondary fs-5"></i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light border text-center text-muted py-3">
                            <i class="bi bi-info-circle me-2"></i> Nenhum endereço cadastrado.
                        </div>
                    <?php endif; ?>

                    <button type="button" class="btn btn-outline-dark mt-3 w-100 fw-semibold py-2"
                        data-bs-toggle="modal" data-bs-target="#modalEndereco">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar Novo Endereço
                    </button>
                    <form action="processar_pagamento.php" method="get">
                        <button type="submit" class="btn btn-danger w-100 mt-4 py-3 fs-5 fw-bold shadow-sm">
                            <i class="bi bi-bag-check-fill me-2"></i> Confirmar Pagamento
                        </button>
                    </form>
                </div>
            </div>
            <!-- MODAL NOVO ENDEREÇO (versão moderna BloodFlower) -->
            <div class="modal fade" id="modalEndereco" tabindex="-1" aria-labelledby="modalEnderecoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <form action="cadEndereco.php" method="POST" class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                        <!-- Cabeçalho -->
                        <div class="modal-header bg-gradient text-white py-3" style="background: linear-gradient(90deg, #8b0000, #a40000);">
                            <h5 class="modal-title fw-semibold d-flex align-items-center" id="modalEnderecoLabel">
                                <i class="bi bi-house-add me-2 fs-4"></i> Novo Endereço
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>

                        <!-- Corpo -->
                        <div class="modal-body p-4 bg-light">
                            <input type="hidden" name="voltar_para_pagamento" value="1">

                            <div class="alert alert-light border-start border-danger border-3 mb-4 rounded-3">
                                <i class="bi bi-info-circle text-danger me-2"></i>
                                <small>Informe o CEP para preencher automaticamente o endereço.</small>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><i class="bi bi-geo-alt-fill text-danger"></i> CEP</label>
                                    <input type="text" class="form-control form-control-lg shadow-sm" name="cep" id="cep" placeholder="00000-000" required onblur="buscarCep(this.value)">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><i class="bi bi-hash text-danger"></i> Número</label>
                                    <input type="text" class="form-control form-control-lg shadow-sm" name="numero" id="numero" placeholder="123" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold"><i class="bi bi-signpost text-danger"></i> Logradouro</label>
                                    <input type="text" class="form-control form-control-lg shadow-sm" name="rua" id="rua" placeholder="Rua, Avenida..." required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><i class="bi bi-buildings text-danger"></i> Bairro</label>
                                    <input type="text" class="form-control form-control-lg shadow-sm" name="bairro" id="bairro" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold"><i class="bi bi-geo text-danger"></i> Cidade</label>
                                    <input type="text" class="form-control form-control-lg shadow-sm" name="cidade" id="cidade" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold"><i class="bi bi-map text-danger"></i> UF</label>
                                    <input type="text" class="form-control form-control-lg shadow-sm text-center" name="estado" id="estado" maxlength="2" required>
                                </div>
                            </div>
                        </div>

                        <!-- Rodapé -->
                        <div class="modal-footer bg-white py-3 justify-content-center">
                            <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-semibold shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Salvar Endereço
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RESUMO -->
            <div class="col-md-6">
                <div class="pagamento-box">
                    <h5 class="pagamento-titulo"><i class="bi bi-receipt"></i> Resumo da Compra</h5>
                    <?php foreach ($produtos as $item): ?>
                        <div class="d-flex align-items-center mb-3 resumo-item">
                            <img src="imagens/<?= $item['imagem'] ?>" alt="<?= $item['nome'] ?>" width="60" class="me-3 rounded">
                            <div>
                                <strong><?= $item['nome'] ?></strong><br>
                                <small><?= $item['quantidade'] ?>x R$ <?= number_format($item['preco'], 2, ',', '.') ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Total:</h5>
                        <span class="valor-total">R$ <?= number_format($total, 2, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <p>&copy; 2025 BloodFlower. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>

<script>
    function buscarCep(cep) {
        cep = cep.replace(/\D/g, '');
        limparCampos();
        if (cep.length !== 8) {
            alert("CEP inválido.");
            return;
        }
        fetch(`https://viacep.com.br/ws/${cep}/json/`).then(response => response.json()).then(dados => {
            if (dados.erro) {
                alert("CEP não encontrado.");
                limparCampos();
                return;
            }
            document.getElementById('rua').value = dados.logradouro;
            document.getElementById('bairro').value = dados.bairro;
            document.getElementById('cidade').value = dados.localidade;
            document.getElementById('estado').value = dados.uf;
            document.getElementById('rua').readOnly = true;
            document.getElementById('bairro').readOnly = true;
            document.getElementById('cidade').readOnly = true;
            document.getElementById('estado').readOnly = true;
        }).catch(() => {
            alert("Erro ao buscar o CEP. Tente novamente.");
            limparCampos();
        });
    }

    function limparCampos() {
        const campos = ['rua', 'bairro', 'cidade', 'estado'];
        campos.forEach(id => {
            document.getElementById(id).value = "";
            document.getElementById(id).readOnly = false;
        });
    }
</script>

</html>