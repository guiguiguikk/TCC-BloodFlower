<?php
include("conexao.php");
session_start();

$categoriaAtual = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

$sql = "SELECT * FROM produtos WHERE 1=1";

if ($categoriaAtual > 0) {
    $sql .= " AND categoria_id = $categoriaAtual";
}
if (!empty($busca)) {
    $buscaEscapada = mysqli_real_escape_string($conn, $busca);
    $sql .= " AND (nome LIKE '%$buscaEscapada%' OR descricao LIKE '%$buscaEscapada%')";
}

// --- LIMITADOR DE PRODUTOS ---
$porPagina = 8; // quantos produtos exibir por vez
$pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($pagina - 1) * $porPagina;

// consulta para contar total
$sqlCount = $sql;
$resCount = mysqli_query($conn, $sqlCount);
$totalProdutos = mysqli_num_rows($resCount);

// aplica limitador na query final
$sql .= " LIMIT $porPagina OFFSET $offset";

$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF8">
    <title>BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="imagens/LogoBloodFlower.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">

    <style>
        /* Estilos anteriores (reduzidos por brevidade)... */
        body {
            font-family: 'Rubik', sans-serif;
            background: linear-gradient(180deg, #fff 0%, #f8f8f8 100%);
            color: #333;
            overflow-x: hidden;
            position: relative;
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

        /* SEARCH BAR ... (sem alterações) */
        .search-bar {
            max-width: 600px;
            margin: 120px auto 40px;
            text-align: center;
            animation: fadeIn 1s ease-in;
        }

        .search-bar input {
            border-radius: 50px 0 0 50px;
            border: 2px solid #8b0000;
            padding-left: 20px;
        }

        .search-bar button {
            border-radius: 0 50px 50px 0;
            background: #8b0000;
            border: 2px solid #8b0000;
        }

        .search-bar button:hover {
            background: #a90000;
        }


        /* --- MUDANÇA: ADICIONADO PERSPECTIVE AO CONTAINER DO CARD --- */
        /* Isso dá o "contexto" 3D para o efeito de hover */
        .col-sm-6.col-md-4.col-lg-3 {
            perspective: 1000px;
        }

        /* PRODUCT CARDS */
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            /* Essencial para o stretched-link funcionar */
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            /* Animação de entrada */
            transform: translateY(20px);
            opacity: 0;
            /* --- MUDANÇA: TRANSIÇÃO ATUALIZADA --- */
            transition: all 0.3s ease-in-out;
        }

        .card.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- NOVO: EFEITO 3D NO HOVER --- */
        .card:hover {
            transform: scale(1.02) rotateY(3deg) rotateX(1deg) translateZ(5px);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.15), 0 10px 10px rgba(0, 0, 0, 0.1);
        }

        .card img {
            height: 260px;
            object-fit: contain;
            background: #fafafa;
            transition: transform 0.4s;
        }

        /* --- REMOVIDO: EFEITO DE ZOOM ANTIGO --- */
        /* Removemos .card:hover img { ... } pois agora o card inteiro se move */

        .card-body {
            text-align: center;
            padding: 20px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .price {
            color: #28a745;
            font-weight: 600;
        }

        /* --- REMOVIDO: ESTILOS DO BOTÃO OVERLAY --- */
        /* .card .overlay-btn { ... } */
        /* .card:hover .overlay-btn { ... } */
        /* .overlay-btn .btn { ... } */


        /* FOOTER ... (sem alterações) */
        footer {
            background: #111;
            color: #ccc;
            padding: 50px 0 20px;
        }

        footer h5 {
            color: #fff;
            font-weight: 600;
        }

        footer a {
            color: #bbb;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 30px;
            text-align: center;
            padding-top: 10px;
            color: #777;
            font-size: 0.9rem;
        }

        /* ANIMATIONS ... (sem alterações) */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #backToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            z-index: 100;
            opacity: 0;
            transition: opacity 0.3s, transform 0.3s;
            transform: translateY(20px);
            border-radius: 50%;
            background-color: #8b0000;
            border: none;
        }

        #backToTop.show {
            display: inline-block;
            opacity: 0.8;
            transform: translateY(0);
        }

        #backToTop:hover {
            opacity: 1;
            background-color: #a90000;
        }

        /* Paginação BloodFlower */
        .pagination .page-link {
            color: #8b0000;
            border: 1px solid #8b0000;
        }

        .pagination .page-link:hover {
            background-color: #8b0000;
            color: white;
        }

        .pagination .active .page-link {
            background-color: #8b0000;
            border-color: #8b0000;
            color: white;
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
                    <li class="nav-item"><a class="nav-link <?= ($categoriaAtual == 0 && empty($busca)) ? 'active' : '' ?>" href="index.php">Todos</a></li>
                    <li class="nav-item"><a class="nav-link <?= $categoriaAtual == 1 ? 'active' : '' ?>" href="index.php?categoria=1">Camisetas</a></li>
                    <li class="nav-item"><a class="nav-link <?= $categoriaAtual == 2 ? 'active' : '' ?>" href="index.php?categoria=2">Calças</a></li>
                    <li class="nav-item"><a class="nav-link <?= $categoriaAtual == 3 ? 'active' : '' ?>" href="index.php?categoria=3">Moletons</a></li>
                    <li class="nav-item"><a class="nav-link <?= $categoriaAtual == 4 ? 'active' : '' ?>" href="index.php?categoria=4">Acessórios</a></li>
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

    <div class="search-bar px-3">
        <form method="GET" action="index.php" class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar produtos..." value="<?= htmlspecialchars($busca); ?>">
            <?php if ($categoriaAtual > 0) { ?>
                <input type="hidden" name="categoria" value="<?= $categoriaAtual; ?>">
            <?php } ?>
            <button class="btn btn-danger" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <div class="container mb-5">
        <div class="row g-4">

            <?php

            if (mysqli_num_rows($result) > 0) {


                while ($produto = mysqli_fetch_assoc($result)) {

            ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100">
                            <img src="imagens/<?= htmlspecialchars($produto['imagem']); ?>" alt="<?= htmlspecialchars($produto['nome']); ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="detalhes.php?id=<?= $produto['id']; ?>" class="stretched-link text-decoration-none text-reset">
                                        <?= htmlspecialchars($produto['nome']); ?>
                                    </a>
                                </h5>
                                <p class="price">R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="col-12">
                    <div class="alert alert-light text-center border shadow-sm" role="alert" style="animation: fadeIn 1s;">
                        <h4 class="alert-heading text-danger"><i class="bi bi-emoji-frown"></i> Ops!</h4>
                        <p class="lead">Nenhum produto foi encontrado.</p>
                        <?php if (!empty($busca)): ?>
                            <p>Não encontramos resultados para "<strong><?= htmlspecialchars($busca); ?></strong>"
                                <?php if ($categoriaAtual > 0) echo " nesta categoria"; ?>.</p>
                        <?php endif; ?>
                        <hr>
                        <p class="mb-0">Tente redefinir sua busca ou <a href="index.php" class="alert-link">ver todos os produtos</a>.</p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        $totalPaginas = ceil($totalProdutos / $porPagina);

        if ($totalPaginas > 1): ?>
            <nav aria-label="Paginação">
                <ul class="pagination justify-content-center mt-4">

                    <!-- Botão Voltar -->
                    <?php if ($pagina > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pagina - 1 ?>
                        <?php if ($categoriaAtual > 0) echo "&categoria=$categoriaAtual"; ?>
                        <?php if (!empty($busca)) echo "&busca=$busca"; ?>">
                                « Anterior
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Números -->
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>
                        <?php if ($categoriaAtual > 0) echo "&categoria=$categoriaAtual"; ?>
                        <?php if (!empty($busca)) echo "&busca=$busca"; ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Botão Avançar -->
                    <?php if ($pagina < $totalPaginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pagina + 1 ?>
                        <?php if ($categoriaAtual > 0) echo "&categoria=$categoriaAtual"; ?>
                        <?php if (!empty($busca)) echo "&busca=$busca"; ?>">
                                Próxima »
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        <?php endif; ?>


    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>BloodFlower</h5>
                    <p>Vista-se com originalidade e atitude. Moda alternativa para quem quer se destacar.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Início</a></li>
                        <li><a href="index.php">Loja</a></li>
                        <li><a href="#">Contato</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contato</h5>
                    <p><i class="bi bi-envelope"></i> contato@bloodflower.com</p>
                    <p><i class="bi bi-instagram"></i> @bloodflower</p>
                </div>
            </div>
            <div class="footer-bottom">&copy; 2025 BloodFlower. Todos os direitos reservados.</div>
        </div>
    </footer>

    <a href="#" class="btn btn-danger btn-lg" id="backToTop" role="button" title="Voltar ao Topo">
        <i class="bi bi-arrow-up"></i>
    </a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.querySelector('.navbar').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Botão Voltar ao Topo
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Fade-in Otimizado com IntersectionObserver
        const cards = document.querySelectorAll('.card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        cards.forEach(card => {
            observer.observe(card);
        });
    </script>
</body>

</html>