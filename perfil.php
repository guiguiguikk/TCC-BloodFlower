<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
include("conexao.php");
$nome = $_SESSION['nome'];
$secao = $_GET['secao'] ?? 'perfil';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Perfil | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

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
        }

        .nav-link:hover {
            color: #8b0000 !important;
        }

        .sidebar {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            height: 100%;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #f1f1f1;
            color: #dc3545;
        }

        .content-area {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            padding: 30px;
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

            <div class="collapse navbar-collapse" id="navbarNavCliente">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Todos</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=1">Camisetas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=2">Calças</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=3">Moletons</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?categoria=4">Acessórios</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="perfil.php" class="text-dark" title="Perfil"><i class="bi bi-person-circle fs-4"></i></a>
                    <a href="carrinho.php" class="text-dark" title="Carrinho"><i class="bi bi-cart fs-4"></i></a>
                    <a href="favoritos.php" class="text-dark" title="Favoritos"><i class="bi bi-heart fs-4"></i></a>
                    <a href="logoff.php" class="text-dark" title="Sair"><i class="bi bi-box-arrow-right fs-4"></i></a>
                </div>
            </div>
        </div>
    </nav>


    <div class="container mt-5 pt-5">
        <div class="row">
            <!-- Menu lateral -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h5 class="mb-4">Olá, <?php echo htmlspecialchars($nome); ?>!</h5>
                    <a href="?secao=perfil" class="<?php if ($secao == 'perfil') echo 'active'; ?>"><i class="bi bi-person"></i> Meu Perfil</a>
                    <a href="?secao=pedidos" class="<?php if ($secao == 'pedidos') echo 'active'; ?>"><i class="bi bi-receipt"></i> Meus Pedidos</a>
                    <a href="?secao=favoritos" class="<?php if ($secao == 'favoritos') echo 'active'; ?>"><i class="bi bi-heart"></i> Favoritos</a>
                    <a href="?secao=endereco" class="<?php if ($secao == 'endereco') echo 'active'; ?>"><i class="bi bi-geo-alt"></i> Endereço</a>
                    <a href="?secao=senha" class="<?php if ($secao == 'senha') echo 'active'; ?>"><i class="bi bi-lock"></i> Alterar Senha</a>
                    <a href="logoff.php" onclick="return confirm('Tem certeza que deseja sair?')" class="text-danger"><i class="bi bi-box-arrow-right"></i> Sair</a>
                </div>
            </div>

            <!-- Conteúdo dinâmico -->
            <div class="col-md-9">
                <div class="content-area">
                    <?php
                    switch ($secao) {
                        case 'perfil':
                            $id_usuario = $_SESSION['id'];
                            $sql_usuario = "SELECT * FROM `usuarios` WHERE `id_usuario` = $id_usuario";
                            $result_usuario = mysqli_query($conn, $sql_usuario);

                            if (!$result_usuario) {
                                die("Erro na consulta: " . mysqli_error($conn));
                            }

                            $usuario = mysqli_fetch_assoc($result_usuario);

                    ?>

                            <h3>Meu Perfil</h3>
                            <?php if (isset($_SESSION['sucesso_atualizacao'])): ?>
                                <div class="alert alert-success">
                                    <?= $_SESSION['sucesso_atualizacao']; ?>
                                    <?php unset($_SESSION['sucesso_atualizacao']); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['erro_atualizacao'])): ?>
                                <div class="alert alert-danger">
                                    <?= $_SESSION['erro_atualizacao']; ?>
                                    <?php unset($_SESSION['erro_atualizacao']); ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="atualizar_perfil.php" class="mt-4">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($usuario['data_nascimento']) ?>">
                                </div>

                                <button type="submit" class="btn btn-danger">Atualizar Perfil</button>
                            </form>

                        <?php
                            break;
                        case 'pedidos':
                            $id_usuario = $_SESSION['id'];
                            // Consulta os pedidos do usuário ordenados por data decrescente
                            $sql_pedidos = "SELECT * FROM pedidos WHERE id_usuario = $id_usuario ORDER BY data_pedido DESC";
                            $result_pedidos = mysqli_query($conn, $sql_pedidos);

                            if (!$result_pedidos) {
                                die("Erro na consulta de pedidos: " . mysqli_error($conn));
                            }

                            echo "<h3>Meus Pedidos</h3>";

                            if (mysqli_num_rows($result_pedidos) > 0) {
                                echo "<table class='table table-striped mt-4'>";
                                echo "<thead><tr>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Ações</th>
                                    </tr></thead>";
                                echo "<tbody>";
                                while ($pedido = mysqli_fetch_assoc($result_pedidos)) {
                                    echo "<tr>";
                                    echo "<td>" . date('d/m/Y', strtotime($pedido['data_pedido'])) . "</td>";
                                    echo "<td>" . htmlspecialchars($pedido['status']) . "</td>";
                                    echo "<td>R$ " . number_format($pedido['total'], 2, ',', '.') . "</td>";
                                    echo "<td><a href='detalhes_pedido.php?id=" . $pedido['id'] . "' class='btn btn-sm btn-outline-danger'>Detalhes</a></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<p class='mt-4'>Você ainda não realizou nenhum pedido.</p>";
                            }
                            break;
                        case 'favoritos':
                            $id_usuario = $_SESSION['id'];

                            // Primeiro, buscar o ID da lista de favoritos do usuário
                            $sql_favorito = "SELECT id_favorito FROM favorito WHERE usuario_id = $id_usuario LIMIT 1";
                            $result_favorito = mysqli_query($conn, $sql_favorito);

                            if (!$result_favorito) {
                                die("Erro ao buscar favorito: " . mysqli_error($conn));
                            }

                            $row_favorito = mysqli_fetch_assoc($result_favorito);

                            if ($row_favorito) {
                                $id_favorito = $row_favorito['id_favorito'];

                                // Agora, buscar os produtos associados a esse favorito
                                $sql_produtos = "
                                                    SELECT p.*
                                                    FROM item_favorito i
                                                    JOIN produtos p ON i.produto_id = p.id
                                                    WHERE i.favorito_id = $id_favorito
                                                ";

                                $result_produtos = mysqli_query($conn, $sql_produtos);

                                if (!$result_produtos) {
                                    die("Erro ao buscar produtos favoritos: " . mysqli_error($conn));
                                }

                                echo "<h3>Meus Favoritos</h3>";

                                if (mysqli_num_rows($result_produtos) > 0) {
                                    echo "<div class='row mt-4'>";
                                    while ($produto = mysqli_fetch_assoc($result_produtos)) {
                                        echo "<div class='col-md-4 mb-4'>";
                                        echo "<div class='card h-100'>";
                                        echo "<img src='imagens/" . htmlspecialchars($produto['imagem']) . "' class='card-img-top' alt='" . htmlspecialchars($produto['nome']) . "'>";
                                        echo "<div class='card-body'>";
                                        echo "<h5 class='card-title'>" . htmlspecialchars($produto['nome']) . "</h5>";
                                        echo "<p class='card-text'>R$ " . number_format($produto['preco'], 2, ',', '.') . "</p>";
                                        echo "<a href='detalhes.php?id=" . $produto['id'] . "' class='btn btn-outline-danger'>Ver Produto</a>";
                                        echo "</div></div></div>";
                                    }
                                    echo "</div>";
                                } else {
                                    echo "<h3>Meus Favoritos</h3>";
                                    echo "<p class='mt-4'>Você ainda não tem uma lista de favoritos.</p>";
                                }
                            }

                            break;
                        case 'endereco':
                            $id_usuario = $_SESSION['id'];

                            // Buscar todos os endereços do usuário
                            $sql_enderecos = "SELECT * FROM enderecos WHERE usuario_id = $id_usuario";
                            $result_enderecos = mysqli_query($conn, $sql_enderecos);

                            echo '<h3>Meus Endereços</h3>';
                            if (isset($_SESSION['mensagem_endereco'])) {
                                $mensagem = $_SESSION['mensagem_endereco'];
                                echo "<div class='alert alert-{$mensagem['tipo']}'>{$mensagem['texto']}</div>";
                                unset($_SESSION['mensagem_endereco']);
                            }

                            echo '<a href="cadastrar_endereco.php" class="btn btn-success mb-3">Cadastrar Novo Endereço</a>';

                            if (mysqli_num_rows($result_enderecos) > 0) {
                                echo '<div class="list-group">';
                                while ($endereco = mysqli_fetch_assoc($result_enderecos)) {
                                    echo '<div class="list-group-item">';
                                    echo "<strong>{$endereco['rua']}, {$endereco['numero']}</strong><br>";
                                    echo "{$endereco['bairro']} - {$endereco['cidade']}/{$endereco['estado']} - CEP: {$endereco['cep']}<br>";

                                    echo '<a href="editar_endereco.php?id=' . $endereco['id_endereco'] . '" class="btn btn-sm btn-warning me-2 mt-2">Editar</a>';
                                    echo '<a href="excluir_endereco.php?id=' . $endereco['id_endereco'] . '" class="btn btn-sm btn-danger mt-2" onclick="return confirm(\'Tem certeza que deseja excluir este endereço?\')">Excluir</a>';
                                    echo '</div>';
                                }
                                echo '</div>';
                            } else {
                                echo '<p>Você ainda não cadastrou endereços.</p>';
                            }

                            break;
                        case 'senha':
                        ?>
                            <h3>Alterar Senha</h3>
                            <?php if (isset($_SESSION['sucesso_senha'])): ?>
                                <div class="alert alert-success">
                                    <?= $_SESSION['sucesso_senha']; ?>
                                    <?php unset($_SESSION['sucesso_senha']); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['erro_senha'])): ?>
                                <div class="alert alert-danger">
                                    <?= $_SESSION['erro_senha']; ?>
                                    <?php unset($_SESSION['erro_senha']); ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="atualizar_senha.php" class="mt-4">
                                <div class="mb-3">
                                    <label for="senha_atual" class="form-label">Senha Atual</label>
                                    <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nova_senha" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                </div>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja atualizar a senha?')">Atualizar Senha</button>
                            </form>
                    <?php
                            break;
                        default:
                            echo "<p>Seção inválida.</p>";
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>