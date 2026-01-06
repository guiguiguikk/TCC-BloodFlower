<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
$secao = $_GET['secao'] ?? 'produto';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Admin | BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #8b0000 !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 44px;
            margin-right: 10px;
        }

        h1 {
            color: #8b0000;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .btn-admin {
            background-color: #8b0000;
            color: #fff;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-admin:hover {
            background-color: #660000;
        }

        .table thead {
            background-color: #8b0000;
            color: white;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="inicioADM.php">
                <img src="../imagens/LogoBloodFlower.png" alt="Logo">
                BloodFlower
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAdmin">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="<?php if ($secao  == "produto") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="inicioADM.php?secao=produto"><i class="bi bi-box"></i> Produtos</a></li>
                    <li class="nav-item"><a class="<?php if ($secao  == "pedidos") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="?secao=pedidos"><i class="bi bi-bag-check"></i> Pedidos</a></li>
                    <li class="nav-item"><a class="<?php if ($secao  == "avaliacoes") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="?secao=avaliacoes"><i class="bi bi-star"></i> Avaliações</a></li>
                    <li class="nav-item"><a class="<?php if ($secao  == "usuario") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="?secao=usuario"><i class="bi bi-people"></i> Usuários</a></li>
                    <li class="nav-item"><a class="<?php if ($secao  == "enderecos") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="?secao=enderecos"><i class="bi bi-geo-alt"></i> Endereços</a></li>
                    <li class="nav-item"><a class="<?php if ($secao  == "marcas") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="?secao=marcas"><i class="bi bi-tags"></i> Marcas</a></li>
                    <li class="nav-item"><a class="<?php if ($secao  == "categorias") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="?secao=categorias"><i class="bi bi-folder"></i> Categorias</a></li>
                    <li class="nav-item"><a class="<?php if ($secao  == "tamanhos") echo "nav-link active fw-bold text-danger";
                                                    else echo "nav-link" ?>" href="?secao=tamanhos"><i class="bi bi-tag"></i> Tamanhos</a></li>
                </ul>
                <a href="../logoff.php" class="btn btn-outline-dark"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </div>
    </nav>

    <?php
    switch ($secao) {
        case "produto":
    ?>
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Produtos</h1>
                    <a href="formProduto.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Produto</a>
                </div>

                <?php
                $sql = "SELECT p.id, p.nome, p.preco, p.descricao, p.estoque,
                   c.nome AS categoria_nome, m.nome AS marca_nome
            FROM produtos p
            JOIN categorias c ON p.categoria_id = c.id_categoria
            JOIN marca m ON p.marca_id = m.id_marca";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Descrição</th>
                <th>Estoque</th>
                <th>Categoria</th>
                <th>Marca</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
                        echo "<td>{$row['descricao']}</td>";
                        echo "<td>{$row['estoque']}</td>";
                        echo "<td>{$row['categoria_nome']}</td>";
                        echo "<td>{$row['marca_nome']}</td>";
                        echo "<td class='text-center'>
                    <a href='formEditProduto.php?id={$row['id']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
                        echo "<td class='text-center'>
                    <a href='excluirProduto.php?id={$row['id']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>

        <?php
            break;

        case 'pedidos':
        ?>
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Pedidos</h1>
                </div>

                <?php
                $sql = "SELECT p.id, p.data_pedido, p.status, p.total,
                       u.nome AS usuarios_nome
                FROM pedidos p
                JOIN usuarios u ON p.id_usuario = u.id_usuario";
                $result = mysqli_query($conn, $sql);

                // ⚠ AQUI ESTAVA O ERRO PRINCIPAL: HTML sem fechar PHP antes!
                if (isset($_SESSION['mensagem'])):
                ?>
                    <div class="alert alert-<?= $_SESSION['mensagem']['tipo']; ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['mensagem']['text']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php
                    unset($_SESSION['mensagem']);
                endif;

                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                    <th>ID do pedido</th>
                    <th>Nome do cliente</th>
                    <th>Valor Total</th>
                    <th>Status</th>
                    <th>Data / Hora</th>
                    <th class='text-center' colspan='3'>Ações</th>
                </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['usuarios_nome']}</td>";
                        echo "<td>R$ " . number_format($row['total'], 2, ',', '.') . "</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>" . date("d/m/Y H:i", strtotime($row['data_pedido'])) . "</td>";

                        echo "<td class='text-center'>
                        <a href='excluirPedido.php?id_pedido={$row['id']}' class='text-danger' 
                           onclick='return confirm(\"Tem certeza que deseja excluir este pedido?\")'>
                            <i class='bi bi-trash'></i>
                        </a>
                      </td>";

                        echo "<td class='text-center'>
                        <a href='detalhesPedido.php?id_pedido={$row['id']}' class='text-primary'>
                            <i class='bi bi-file-earmark-text-fill'></i>
                        </a>
                      </td>";

                      echo "<td class='text-center'>
                        <a href='formEditPedido.php?id_pedido={$row['id']}' class='text-primary'>
                            <i class='bi bi-pencil-square'></i>
                        </a>
                      </td>";

                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum pedido registrado.</p>";
                }
                ?>
            </div>
        <?php
            break;


        case "avaliacoes":
        ?>
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Avaliações</h1>
                    <a href="formAvaliacao.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Avaliações</a>
                </div>

                <?php
                $sql = "SELECT a.id_avaliacao, a.data_hora, a.comentario, a.nota,
                u.nome AS usuarios_nome, p.nome AS produtos_nome
                FROM avaliacoes a
                JOIN usuarios u ON a.usuario_id = u.id_usuario
                JOIN produtos p ON a.produto_id = p.id";

                $result = mysqli_query($conn, $sql);


                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                <th>ID da avaliação</th>
                <th>Nome do usuario</th>
                <th>Produto</th>
                <th>Comentario</th>
                <th>Nota</th>
                <th>Data e hora</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_avaliacao']}</td>";
                        echo "<td>{$row['usuarios_nome']}</td>";
                        echo "<td>{$row['produtos_nome']}</td>";
                        echo "<td>{$row['comentario']}</td>";
                        echo "<td>{$row['nota']}</td>";
                        echo "<td>" . date($row['data_hora']) . "</td>";
                        echo "<td class='text-center'>
                    <a href='excluirAvaliacao.php?id_avaliacao={$row['id_avaliacao']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
                        echo "<td class='text-center'>
                    <a href='formEditAvaliacao.php?id_avaliacao={$row['id_avaliacao']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>

        <?php

            break;

        case "usuario":

        ?>
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Usuarios</h1>
                    <a href="formUsuario.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Usuario</a>
                </div>

                <?php
                $sql = "SELECT * FROM usuarios";

                $result = mysqli_query($conn, $sql);


                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                <th>ID do usuário</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Data De Nascimento</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_usuario']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td>{$row['cpf']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['telefone']}</td>";
                        echo "<td>" . date($row['data_nascimento']) . "</td>";
                        echo "<td class='text-center'>
                    <a href='excluirUsuario.php?id_usuario={$row['id_usuario']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
                        echo "<td class='text-center'>
                    <a href='formEditUsuario.php?id_usuario={$row['id_usuario']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>

        <?php



            break;
        case 'enderecos':
        ?>
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Endereços</h1>
                    <a href="formEndereco.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Endereço</a>
                </div>

                <?php
                $sql = "SELECT e.id_endereco, u.nome AS nome_usuario, e.cep, e.rua, e.numero, e.bairro, e.cidade, e.estado
                FROM enderecos e
                JOIN usuarios u ON e.usuario_id = u.id_usuario";

                $result = mysqli_query($conn, $sql);


                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                <th>ID do endereços</th>
                <th>Nome do usuario</th>
                <th>CEP</th>
                <th>Rua</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_endereco']}</td>";
                        echo "<td>{$row['nome_usuario']}</td>";
                        echo "<td>{$row['cep']}</td>";
                        echo "<td>{$row['rua']}</td>";
                        echo "<td>{$row['bairro']}</td>";
                        echo "<td>{$row['cidade']}</td>";
                        echo "<td>{$row['estado']}</td>";
                        echo "<td class='text-center'>
                    <a href='excluirEndereco.php?id_endereco={$row['id_endereco']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
                        echo "<td class='text-center'>
                    <a href='formEditEndereco.php?id_endereco={$row['id_endereco']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>

        <?php

            break;
        case "marcas":

        ?>
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Marcas</h1>
                    <a href="formMarca.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Marca</a>
                </div>

                <?php
                $sql = "SELECT * FROM marca";

                $result = mysqli_query($conn, $sql);


                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                <th>ID da Marca</th>
                <th>Nome</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_marca']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td class='text-center'>
                    <a href='excluirMarca.php?id_marca={$row['id_marca']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
                        echo "<td class='text-center'>
                    <a href='formEditMarca.php?id_marca={$row['id_marca']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>

        <?php

            break;

        case "categorias":
        ?>
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Categorias</h1>
                    <a href="formCategoria.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Categoria</a>
                </div>

                <?php
                $sql = "SELECT * FROM categorias";

                $result = mysqli_query($conn, $sql);


                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                <th>ID da Categoria</th>
                <th>Nome</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_categoria']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td class='text-center'>
                    <a href='excluirCategoria.php?id_categoria={$row['id_categoria']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
                        echo "<td class='text-center'>
                    <a href='formEditCategoria.php?id_categoria={$row['id_categoria']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>

    <?php
            break;
            case "tamanhos":
        ?>
                    <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gerenciar Tamanhos</h1>
                    <a href="formTamanho.php" class="btn btn-admin"><i class="bi bi-plus-lg"></i> Novo Tamanho</a>
                </div>

                <?php
                $sql = "SELECT * FROM tamanhos";

                $result = mysqli_query($conn, $sql);


                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-hover align-middle'>";
                    echo "<thead><tr>
                <th>ID da Categoria</th>
                <th>Nome</th>
                <th class='text-center' colspan='2'>Ações</th>
              </tr></thead><tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td class='text-center'>
                    <a href='excluirCategoria.php?id_tamanho={$row['id']}' class='text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                  </td>";
                        echo "<td class='text-center'>
                    <a href='formEditCategoria.php?id_tamanho={$row['id']}' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                  </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-muted text-center mt-4'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>

    <?php
            break;
    }
    
    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>