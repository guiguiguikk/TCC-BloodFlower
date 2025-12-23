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

// --- FAVORITO E CARRINHO ---
if (isset($_SESSION['id'])) {
    $favorito = "SELECT * FROM favorito WHERE usuario_id = " . $_SESSION['id'];
    $result_favorito = mysqli_query($conn, $favorito);
    $id_favorito = mysqli_fetch_assoc($result_favorito)['id_favorito'] ?? null;

    $sql_check_favorito = "SELECT * FROM item_favorito WHERE favorito_id = " . $id_favorito . " AND produto_id = " . $produto['id'];
    $result_check_favorito = mysqli_query($conn, $sql_check_favorito);

    $carrinho = "SELECT * FROM carrinhos WHERE usuario_id = " . $_SESSION['id'];
    $result_carrinho = mysqli_query($conn, $carrinho);
    $id_carrinho = mysqli_fetch_assoc($result_carrinho)['id_carrinho'] ?? null;

    $sql_check_carrinho = "SELECT * FROM itens_carrinho WHERE carrinho_id = " . $id_carrinho . " AND produto_id = " . $produto['id'];
    $result_check_carrinho = mysqli_query($conn, $sql_check_carrinho);
} else {
    $id_carrinho = null;
    $result_check_carrinho = null;
    $id_favorito = null;
    $result_check_favorito = null;
}

// --- AVALIAÇÕES ---
$sql_avaliacoes = "
    SELECT a.*, u.nome as usuario_nome 
    FROM avaliacoes a
    JOIN usuarios u ON u.id_usuario = a.usuario_id
    WHERE a.produto_id = $id
    ORDER BY a.data_hora DESC
";
$query_avaliacao = mysqli_query($conn, $sql_avaliacoes);

// Média de estrelas e total de avaliações
$sqlMedia = "SELECT AVG(nota) as media, COUNT(*) as total FROM avaliacoes WHERE produto_id = $id";
$resultMedia = mysqli_query($conn, $sqlMedia);
$mediaData = mysqli_fetch_assoc($resultMedia);
$mediaEstrelas = $mediaData['media'] ? floatval($mediaData['media']) : 0;
$totalAvaliacoes = intval($mediaData['total'] ?? 0);

// Verifica se o usuário pode avaliar
$podeAvaliar = false;
if (isset($_SESSION['id'])) {
    $usuario_id = $_SESSION['id'];
    $sql_verifica_compra = "
        SELECT ip.id 
        FROM itens_pedido ip
        INNER JOIN pedidos p ON p.id = ip.id_pedido
        WHERE p.id_usuario = $usuario_id 
        AND ip.id_produto = $id 
        AND p.status = 'entregue'
        LIMIT 1
    ";
    $res_verifica_compra = mysqli_query($conn, $sql_verifica_compra);
    if (mysqli_num_rows($res_verifica_compra) > 0) {
        $sql_ja_avaliou = "SELECT id_avaliacao FROM avaliacoes WHERE usuario_id = $usuario_id AND produto_id = $id LIMIT 1";
        $res_ja_avaliou = mysqli_query($conn, $sql_ja_avaliou);
        if (mysqli_num_rows($res_ja_avaliou) == 0) {
            $podeAvaliar = true;
        }
    }
}
$sql_tamanhos = "SELECT * FROM tamanhos";
$result_tamanhos = mysqli_query($conn, $sql_tamanhos);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produto['nome']) ?> | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Rubik', sans-serif;
        }
                /* NAVBAR ... (sem alterações) */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: background 0.4s, box-shadow 0.4s;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .navbar-brand {
            color: #8b0000 !important;
            font-weight: 700;
            display: flex;
            align-items: center;
            font-size: 1.6rem;
        }

        .navbar-brand img {
            height: 48px;
            margin-right: 8px;
        }

        .nav-link {
            color: #555 !important;
            font-weight: 500;
            margin: 0 5px;
            transition: color 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #8b0000 !important;
        }

        .icon-link {
            color: #333;
            transition: transform 0.2s, color 0.2s;
        }

        .icon-link:hover {
            color: #8b0000;
            transform: scale(1.15);
        }

        .produto-container {
            padding: 100px 20px 60px;
        }

        .imagem-box {
            background: #fff;
            padding: 25px;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }

        .imagem-box img {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
        }

        .info-produto h1 {
            font-weight: 700;
            font-size: 2.2rem;
            color: #8b0000;
            margin-bottom: 10px;
        }

        /* título vermelho BloodFlower */
        .preco-produto {
            font-size: 1.8rem;
            color: #28a745;
            font-weight: bold;
        }

        /* preço verde */
        .descricao-produto {
            font-size: 1.05rem;
            color: #555;
            margin: 20px 0;
            white-space: pre-line;
        }

        .extra-info {
            margin-bottom: 20px;
        }

        .extra-info i {
            color: #8b0000;
            margin-right: 8px;
        }

        .botoes-produto {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .botoes-produto .btn {
            font-weight: 600;
            font-size: 1rem;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.2s;
        }

        /* Botões personalizados */
        .btn-danger {
            background-color: #8b0000;
            border-color: #8b0000;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #a30000;
            border-color: #a30000;
        }

        .btn-outline-danger {
            border-color: #8b0000;
            color: #8b0000;
        }

        .btn-outline-danger:hover {
            background-color: #8b0000;
            color: #fff;
        }

        /* Avaliações */
        .bi-star-fill.text-warning {
            color: #ffc107;
        }

        /* estrelas amarelas mantidas */
        .ver-mais {
            cursor: pointer;
        }

        /* Carousel cards */
        .carousel .card img {
            height: 180px;
            object-fit: contain;
            width: 100%;
            border-radius: 8px 8px 0 0;
            background-color: #fff;
        }

        /* Footer */
        footer {
            background-color: #f9f9f9;
            color: #555;
        }

        footer h5 {
            color: #8b0000;
        }

        footer a {
            color: #555;
        }

        footer a:hover {
            color: #8b0000;
            text-decoration: none;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower"> BloodFlower
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavCliente">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavCliente">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                </ul>
                <div class="d-flex gap-3 align-items-center">
                    <?php if (!isset($_SESSION['email'])) { ?>
                        <a href="entrar.php" class="icon-link"><i class="bi bi-box-arrow-in-right fs-4"></i></a>
                    <?php } else { ?>
                        <a href="perfil.php" class="icon-link"><i class="bi bi-person-circle fs-4"></i></a>
                    <?php } ?>
                    <a href="carrinho.php" class="icon-link"><i class="bi bi-cart fs-4"></i></a>
                    <a href="favoritos.php" class="icon-link"><i class="bi bi-heart fs-4"></i></a>
                    <?php if (isset($_SESSION['email'])) { ?>
                        <a href="logoff.php" class="icon-link"><i class="bi bi-box-arrow-right fs-4"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- PRODUTO -->
    <div class="container produto-container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="imagem-box">
                    <img src="imagens/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                </div>
            </div>
            <div class="col-lg-6 info-produto">
                <h1><?= htmlspecialchars($produto['nome']) ?></h1>
                <div class="preco-produto mb-3">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>
                <div class="extra-info">
                    <p><i class="bi bi-truck"></i> Entrega rápida disponível</p>
                    <p><i class="bi bi-box-seam"></i> Estoque limitado</p>
                </div>
                <div class="descricao-produto"><?= nl2br(htmlspecialchars($produto['descricao'])) ?></div>

                <!-- Média de estrelas -->
                <div class="mb-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="bi <?= $i <= round($mediaEstrelas) ? 'bi-star-fill text-warning' : 'bi-star text-secondary' ?>"></i>
                    <?php endfor; ?>
                    <small>(<?= $totalAvaliacoes ?> avaliações)</small>
                </div>

                <div class="botoes-produto mt-4">
                    <?php if ($result_check_carrinho && mysqli_num_rows($result_check_carrinho) > 0): ?>
                        <form action="removerCarrinho.php" method="post">
                            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                            <input type="hidden" name="vem_de" value="detalhes">
                            <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle me-2"></i> Já no Carrinho</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="adicionar_carrinho.php">
                            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                            <input type="hidden" name="vem_de" value="detalhes">
                            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-cart-plus me-2"></i> Adicionar ao Carrinho</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($result_check_favorito && mysqli_num_rows($result_check_favorito) > 0): ?>
                        <form method="POST" action="removerFavorito.php">
                            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                            <input type="hidden" name="vem_de" value="detalhes">
                            <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-heart-fill me-2"></i> Remover dos Favoritos</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="add_favorito.php">
                            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                            <input type="hidden" name="vem_de" value="detalhes">
                            <button type="submit" class="btn btn-outline-dark w-100"><i class="bi bi-heart me-2"></i> Favoritar</button>
                        </form>
                    <?php endif; ?>

                    <?php 
                    if (mysqli_num_rows($result_tamanhos) > 0){
                        ?>
                        <div class="mt-3">
                            <label for="tamanho" class="form-label fw-semibold">Escolha o Tamanho:</label>
                                <?php
                                while ($tamanho = mysqli_fetch_assoc($result_tamanhos)) {?>
                                <input type="radio" class="btn-check" name="tamanho" id="tamanho<?= $tamanho['id'] ?>" autocomplete="off">
                                <label class="btn btn-outline-secondary me-2" for="tamanho<?= $tamanho['id'] ?>"><?= htmlspecialchars($tamanho['nome']) ?></label>
                                <?php
                                   
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                        <?php
                    }  ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Avaliações -->
    <div class="container my-5">
        <h3 class="mb-4 fw-bold">Avaliações dos Clientes</h3>

        <?php if ($podeAvaliar): ?>
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body">
                    <form method="POST" action="salvar_avaliacao.php">
                        <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sua Nota</label>
                            <select name="nota" class="form-select" required>
                                <option value="">Selecione...</option>
                                <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
                                <option value="4">⭐⭐⭐⭐ Muito bom</option>
                                <option value="3">⭐⭐⭐ Bom</option>
                                <option value="2">⭐⭐ Regular</option>
                                <option value="1">⭐ Ruim</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comentário</label>
                            <textarea name="comentario" class="form-control" rows="3" placeholder="Escreva sua experiência..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Enviar Avaliação</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (mysqli_num_rows($query_avaliacao) > 0): ?>
                <?php while ($av = mysqli_fetch_assoc($query_avaliacao)): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="https://i.pravatar.cc/50?u=<?= $av['usuario_id'] ?>" class="rounded-circle me-2" width="45" height="45" alt="avatar">
                                    <div>
                                        <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($av['usuario_nome']) ?></h6>
                                        <small class="text-muted"><?= date("d/m/Y", strtotime($av['data_hora'])) ?></small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi <?= $i <= $av['nota'] ? 'bi-star-fill text-warning' : 'bi-star text-warning' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-muted flex-grow-1 comentario mb-2"><?= nl2br(htmlspecialchars($av['comentario'])) ?></p>
                                <?php if (strlen($av['comentario']) > 120): ?>
                                    <span class="text-danger small fw-semibold ver-mais" role="button">Ver mais</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Nenhuma avaliação ainda.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recomendações -->
    <?php
    $categoria_id = $produto['categoria_id'];
    $marca_id = $produto['marca_id'];
    $produto_id = $produto['id'];
    $sql_recomendados = "SELECT * FROM produtos WHERE id != $produto_id AND (categoria_id=$categoria_id OR marca_id=$marca_id) LIMIT 10";
    $result_recomendados = mysqli_query($conn, $sql_recomendados);
    if (mysqli_num_rows($result_recomendados) > 0):
    ?>
        <div class="container mt-5">
            <h3 class="mb-4">Você pode gostar também</h3>
            <div id="carouselRecomendados" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $produtos = [];
                    while ($row = mysqli_fetch_assoc($result_recomendados)) $produtos[] = $row;
                    $produtos_por_slide = 4;
                    $slides = ceil(count($produtos) / $produtos_por_slide);
                    for ($i = 0; $i < $slides; $i++):
                    ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <div class="row">
                                <?php for ($j = 0; $j < $produtos_por_slide; $j++):
                                    $index = $i * $produtos_por_slide + $j;
                                    if ($index >= count($produtos)) break;
                                    $p = $produtos[$index];
                                ?>
                                    <div class="col-6 col-md-3">
                                        <div class="card">
                                            <img src="imagens/<?= htmlspecialchars($p['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nome']) ?>">
                                            <div class="card-body">
                                                <h6 class="card-title"><?= htmlspecialchars($p['nome']) ?></h6>
                                                <p class="card-text text-danger">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                                                <a href="detalhes.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary w-100">Ver Produto</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselRecomendados" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselRecomendados" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- FOOTER -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>BloodFlower</h5>
                    <p>Vista-se com originalidade e atitude. Roupas alternativas para quem quer se destacar.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-muted text-decoration-none">Início</a></li>
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
            <div class="footer-bottom mt-4 text-center text-muted">
                &copy; 2025 BloodFlower. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".ver-mais").forEach(btn => {
                btn.addEventListener("click", () => {
                    const p = btn.previousElementSibling;
                    p.classList.toggle("expandido");
                    btn.textContent = p.classList.contains("expandido") ? "Ver menos" : "Ver mais";
                });
            });
        });
    </script>
</body>

</html>