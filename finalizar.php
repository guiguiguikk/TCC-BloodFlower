<?php
include("conexao.php");
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_usuario = $_SESSION["id"];

// Buscar o carrinho do usuário
$sql_carrinho = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result_carrinho = mysqli_query($conn, $sql_carrinho);

if (mysqli_num_rows($result_carrinho) == 0) {
    header("Location: carrinho.php");
    exit;
}

$carrinho = mysqli_fetch_assoc($result_carrinho);
$id_carrinho = $carrinho["id_carrinho"];

// Buscar itens do carrinho
$sql_itens = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho";
$result_itens = mysqli_query($conn, $sql_itens);

$total = 0;
$itens = [];

while ($item = mysqli_fetch_assoc($result_itens)) {
    $produto_id = $item["produto_id"];
    $quantidade = $item["quantidade"];

    $sql_produto = "SELECT * FROM produtos WHERE id = $produto_id";
    $result_produto = mysqli_query($conn, $sql_produto);
    $produto = mysqli_fetch_assoc($result_produto);

    $subtotal = $produto["preco"] * $quantidade;
    $total += $subtotal;

    $itens[] = [
        "id_produto" => $produto_id,
        "nome" => $produto["nome"],
        "quantidade" => $quantidade,
        "preco" => $produto["preco"],
        "subtotal" => $subtotal
    ];
}

//cria um pedido na tabela de pedidos
$sql_pedido = "INSERT INTO pedidos (id_usuario, total, data_pedido, status) VALUES ($id_usuario, $total, NOW() , 'Pendente')";
mysqli_query($conn, $sql_pedido);

// Obtém o ID do pedido recém-criado
$id_pedido = mysqli_insert_id($conn);

// Insere os itens do carrinho na tabela de pedidos_itens
foreach ($itens as $item) {
    $produto_id = $item['id_produto'];
    // Escapa o nome do produto para evitar SQL Injection
    $nome = mysqli_real_escape_string($conn, $item['nome']);
    $quantidade = $item['quantidade'];
    $preco = $item['preco'];
    $subtotal = $item['subtotal'];

    $sql_pedido_item = "INSERT INTO itens_pedido (id_pedido,id_produto, quantidade, preco, subtotal) VALUES ($id_pedido, $produto_id,  $quantidade, $preco, $subtotal)";
    mysqli_query($conn, $sql_pedido_item);
}

// Simula a finalização limpando o carrinho
mysqli_query($conn, "DELETE FROM itens_carrinho WHERE carrinho_id = $id_carrinho");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Compra Finalizada | BloodFlower</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="text-success">Compra Finalizada com Sucesso!</h2>
        <p class="text-muted">Obrigado por comprar conosco. Aqui está o resumo da sua compra:</p>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <?php if (count($itens) > 0) { ?>
                <ul class="list-group mb-4">
                    <?php foreach ($itens as $item) { ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($item['nome']); ?> (<?php echo $item['quantidade']; ?>x)
                            <span>R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></span>
                        </li>
                    <?php } ?>
                </ul>
                <h5 class="text-end">Total: <span class="text-success">R$ <?php echo number_format($total, 2, ',', '.'); ?></span></h5>
            <?php } else { ?>
                <p class="text-center text-muted">Seu carrinho estava vazio.</p>
            <?php } ?>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-dark">Voltar à Loja</a>
    </div>
</div>

</body>
</html>
