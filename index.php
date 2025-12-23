<?php
include("conexao.php");
session_start();


$categoriaAtual = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;
$marcaAtual = isset($_GET['marca']) ? (int) $_GET['marca'] : 0;
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$ordenacao = isset($_GET['ordem']) ? $_GET['ordem'] : 'recente';


// Base SQL
$sql = "SELECT * FROM produtos WHERE 1=1";


if ($categoriaAtual > 0) {
    $sql .= " AND categoria_id = $categoriaAtual";
}
if ($marcaAtual > 0) {
    $sql .= " AND marca_id = $marcaAtual";
}
if (!empty($busca)) {
    $buscaEscapada = mysqli_real_escape_string($conn, $busca);
    $sql .= " AND (nome LIKE '%$buscaEscapada%' OR descricao LIKE '%$buscaEscapada%')";
}


// Ordenação
switch ($ordenacao) {
    case 'preco_menor':
        $sql .= " ORDER BY COALESCE(preco_desconto, preco) ASC";
        break;
    case 'preco_maior':
        $sql .= " ORDER BY COALESCE(preco_desconto, preco) DESC";
        break;
    case 'desconto':
        $sql .= " ORDER BY (CASE WHEN preco_desconto IS NOT NULL AND preco_desconto > 0 AND preco_desconto < preco THEN (preco - preco_desconto) ELSE 0 END) DESC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
}


// Paginação
$porPagina = 12;
$pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($pagina - 1) * $porPagina;


$sqlCount = $sql;
$resCount = mysqli_query($conn, $sqlCount);
$totalProdutos = mysqli_num_rows($resCount);


$sql .= " LIMIT $porPagina OFFSET $offset";
$result = mysqli_query($conn, $sql);


// Produtos em destaque (com desconto válido)
$destaque_sql = "SELECT * FROM produtos WHERE preco_desconto IS NOT NULL AND preco_desconto > 0 AND preco_desconto < preco ORDER BY (preco - preco_desconto) DESC LIMIT 8";
$destaque_result = mysqli_query($conn, $destaque_sql);


// Função para calcular desconto válido
function calcularDesconto($preco, $preco_desconto)
{
    if (!$preco_desconto || $preco_desconto <= 0 || $preco_desconto >= $preco) {
        return 0;
    }
    return round(((($preco - $preco_desconto) / $preco) * 100));
}


// Função para obter preço exibido
function getPrecoExibido($preco, $preco_desconto)
{
    if (!$preco_desconto || $preco_desconto <= 0 || $preco_desconto >= $preco) {
        return $preco;
    }
    return $preco_desconto;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <title>BloodFlower - Moda Alternativa Premium</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="imagens/LogoBloodFlower.png" type="image/png">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">


    <style>
        :root {
            --accent-red: #8b0000;
            --accent-red-hover: #a90000;
            --accent-red-light: #f5e6e6;
            --text-primary: #1a1a1a;
            --text-secondary: #666;
            --text-light: #999;
            --bg-primary: #fff;
            --bg-secondary: #fafafa;
            --border: #e8e8e8;
            --border-light: #f2f2f2;
            --shadow-light: 0 2px 6px rgba(0, 0, 0, 0.04);
            --shadow-medium: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 8px 24px rgba(139, 0, 0, 0.1);
            --transition: 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            font-family: 'Rubik', sans-serif;
            background: #f5f5f5;
            color: var(--text-primary);
            overflow-x: hidden;
        }


        /* ========== NAVBAR ORIGINAL ========== */
        .navbar {
            background: rgba(255, 255, 255, 0.8); /* Mais transparente (antes era 0.95) */
            backdrop-filter: blur(8px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: background 0.4s, box-shadow 0.4s;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
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
        
        .navbar-brand-title {
            height: 35px; /* Altura ajustada para o texto imagem */
            margin-left: 5px;
            width: auto;
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


        /* ========== HERO SECTION ========== */
        .hero-section {
            width: 100%;
            height: 100vh;
            /* IMAGEM DE FUNDO ALTERADA AQUI */
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(139, 0, 0, 0.2) 100%), url('imagens/hero-background.jpg') center/cover no-repeat;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 70px;
            position: relative;
            overflow: hidden;
        }


        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at center, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
            z-index: 0;
        }

        /* NOVO: Gradiente para suavizar a transição para o catálogo */
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px; /* Altura do degradê */
            background: linear-gradient(to bottom, transparent, #f5f5f5);
            z-index: 5; /* Fica acima do fundo, mas abaixo do texto */
            pointer-events: none;
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            position: relative;
            animation: fadeInUp 1s ease-out;
            max-width: 600px;
        }


        .hero-logo {
            /* TAMANHO REDUZIDO (Era 200px) */
            width: 140px;
            height: auto;
            margin: 0 auto 20px;
            opacity: 0;
            animation: fadeInDown 1s ease-out 0.2s forwards;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }


        .hero-title {
            width: 100%;
            height: auto;
            /* TAMANHO MÁXIMO REDUZIDO (Era 500px) */
            max-width: 350px;
            margin: 0 auto 30px;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.4s forwards;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.4));
        }


        .hero-button {
            display: inline-block;
            padding: 18px 50px;
            background: #8b0000;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all var(--transition);
            border: 2px solid #8b0000;
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.6s forwards;
            box-shadow: 0 8px 24px rgba(139, 0, 0, 0.25);
            cursor: pointer;
        }


        .hero-button:hover {
            background: #a90000;
            border-color: #a90000;
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(139, 0, 0, 0.35);
        }


        .hero-button:active {
            transform: translateY(-2px);
        }


        /* ========== SCROLL INDICATOR ========== */
        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            animation: bounce 2s infinite;
            opacity: 0.8;
        }


        .scroll-indicator i {
            font-size: 1.5rem;
            color: #8b0000;
        }


        @keyframes bounce {


            0%,
            100% {
                transform: translateX(-50%) translateY(0);
            }


            50% {
                transform: translateX(-50%) translateY(10px);
            }
        }


        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }


            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }


            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* ========== SEARCH BAR ========== */
        .search-bar {
            max-width: 600px;
            margin: 40px auto;
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


        /* ========== PRODUCT CARDS ========== */
        .col-sm-6.col-md-4.col-lg-3 {
            perspective: 1000px;
        }


        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }


        .card.show {
            opacity: 1;
            transform: translateY(0);
        }


        .card:hover {
            transform: scale(1.02) translateY(-8px);
            box-shadow: 0 12px 28px rgba(139, 0, 0, 0.12);
            border-color: #8b0000;
        }


        .card img {
            height: 260px;
            object-fit: contain;
            background: #fafafa;
            transition: transform 0.4s;
        }


        .card:hover img {
            transform: scale(1.06);
        }


        .card-body {
            text-align: center;
            padding: 20px;
        }


        .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }


        .price {
            color: #8b0000;
            font-weight: 700;
            font-size: 1.2rem;
        }


        /* ========== FOOTER ========== */
        footer {
            background: #111;
            color: #ccc;
            padding: 50px 0 20px;
            margin-top: 60px;
        }


        footer h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 20px;
        }


        footer a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }


        footer a:hover {
            color: #8b0000;
        }


        footer ul {
            list-style: none;
        }


        footer li {
            margin-bottom: 8px;
            font-size: 0.9rem;
        }


        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 30px;
            text-align: center;
            padding-top: 10px;
            color: #777;
            font-size: 0.9rem;
        }


        /* ========== ANIMATIONS ========== */
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


        /* ========== BACK TO TOP ========== */
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
            width: 50px;
            height: 50px;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
        }


        #backToTop.show {
            display: flex;
            opacity: 0.8;
            transform: translateY(0);
            align-items: center;
            justify-content: center;
        }


        #backToTop:hover {
            opacity: 1;
            background-color: #a90000;
        }


        /* ========== PAGINAÇÃO ========== */
        .pagination .page-link {
            color: #8b0000;
            border: 1px solid #8b0000;
            background-color: #fff;
            transition: all 0.3s;
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


        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .hero-section {
                height: 80vh;
            }


            .hero-logo {
                /* TAMANHO REDUZIDO MOBILE (Era 140px) */
                width: 100px;
            }


            .hero-title {
                /* TAMANHO REDUZIDO MOBILE (Era 300px) */
                max-width: 220px;
            }


            .hero-button {
                padding: 14px 40px;
                font-size: 1rem;
            }


            .search-bar {
                margin: 30px auto;
            }


            .card img {
                height: 200px;
            }


            footer {
                padding: 40px 0 20px;
            }
        }


        @media (max-width: 480px) {
            .hero-section {
                height: 70vh;
            }


            .hero-logo {
                width: 80px;
            }


            .hero-title {
                max-width: 180px;
            }


            .hero-button {
                padding: 12px 30px;
                font-size: 0.95rem;
            }


            .scroll-indicator {
                bottom: 20px;
            }


            .search-bar {
                margin: 20px 15px;
            }


            .card img {
                height: 180px;
            }


            #backToTop {
                width: 44px;
                height: 44px;
                bottom: 15px;
                right: 15px;
            }
        }
    </style>
</head>


<body>
    <!-- NAVBAR ORIGINAL -->
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower">
                <!-- Substituído o texto pela imagem do título -->
                <img src="imagens/hero-title.png" alt="BloodFlower" class="navbar-brand-title">
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


    <!-- HERO SECTION -->
    <section class="hero-section" id="heroSection">
        <div class="hero-content">
            <!-- Logo como imagem -->
            <img src="imagens/LogoBloodFlower.png" alt="BloodFlower Hero Logo" class="hero-logo">
            <!-- Título/Fonte como imagem -->
            <img src="imagens/hero-title.png" alt="BloodFlower Hero Title" class="hero-title">
            <!-- Botão para ir ao catálogo -->
            <a href="#catalog" class="hero-button">Explorar Catálogo</a>
        </div>
        <!-- Indicador de scroll -->
        <div class="scroll-indicator">
            <i class="bi bi-chevron-down"></i>
        </div>
    </section>


    <!-- SEARCH BAR -->
    <div class="search-bar px-3" id="catalog">
        <form method="GET" action="index.php" class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar produtos..." value="<?= htmlspecialchars($busca); ?>">
            <button class="btn btn-danger" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>


    <!-- PRODUCTS CONTAINER -->
    <div class="container mb-5">
        <div class="row g-4">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($produto = mysqli_fetch_assoc($result)) {
                    $desconto = calcularDesconto($produto['preco'], $produto['preco_desconto']);
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
                                <p class="price">R$ <?= number_format(getPrecoExibido($produto['preco'], $produto['preco_desconto']), 2, ',', '.'); ?></p>
                                <?php if ($desconto > 0): ?>
                                    <small class="text-muted text-decoration-line-through">R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></small>
                                    <br>
                                    <span class="badge bg-danger">-<?= $desconto ?>%</span>
                                <?php endif; ?>
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
                            <p>Não encontramos resultados para "<strong><?= htmlspecialchars($busca); ?></strong>"</p>
                        <?php endif; ?>
                        <hr>
                        <p class="mb-0">Tente ajustar sua busca ou <a href="index.php" class="alert-link">ver todos os produtos</a>.</p>
                    </div>
                </div>
            <?php } ?>
        </div>


        <!-- PAGINATION -->
        <?php
        $totalPaginas = ceil($totalProdutos / $porPagina);
        if ($totalPaginas > 1): ?>
            <nav aria-label="Paginação">
                <ul class="pagination justify-content-center mt-4">
                    <?php if ($pagina > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pagina - 1 ?><?php if ($categoriaAtual > 0) echo "&categoria=$categoriaAtual";
                                                                                if (!empty($busca)) echo "&busca=" . urlencode($busca); ?>">
                                « Anterior
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?php if ($categoriaAtual > 0) echo "&categoria=$categoriaAtual";
                                                                        if (!empty($busca)) echo "&busca=" . urlencode($busca); ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>


                    <?php if ($pagina < $totalPaginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pagina + 1 ?><?php if ($categoriaAtual > 0) echo "&categoria=$categoriaAtual";
                                                                                if (!empty($busca)) echo "&busca=" . urlencode($busca); ?>">
                                Próxima »
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>


    <!-- FOOTER -->
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


    <!-- BACK TO TOP -->
    <a href="#" class="btn btn-danger btn-lg" id="backToTop" role="button" title="Voltar ao Topo">
        <i class="bi bi-arrow-up"></i>
    </a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.querySelector('.navbar').classList.toggle('scrolled', window.scrollY > 50);
        });


        // Back to top button
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