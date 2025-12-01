<?php
session_start();
include("conexao.php");

// Verifica se o usuário está logado e é cliente
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_usuario = $_SESSION["id"];

// carrinho do usuario
$sql_carrinho = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result_carrinho = mysqli_query($conn, $sql_carrinho);

if (!$result_carrinho || mysqli_num_rows($result_carrinho) == 0) {
    die("Carrinho não encontrado.");
}

$carrinho = mysqli_fetch_assoc($result_carrinho);
$id_carrinho = $carrinho['id_carrinho'];

// pegando itens do carrinho
$sql_itens = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho";
$result_itens = mysqli_query($conn, $sql_itens);

if (!$result_itens || mysqli_num_rows($result_itens) == 0) {
    die("Seu carrinho está vazio.");
}

// calculando total do pedido
$total = 0;
$itens = [];

while ($item = mysqli_fetch_assoc($result_itens)) {
    $produto_id = $item['produto_id'];
    $quantidade = $item['quantidade'];

    $sql_prod = "SELECT preco FROM produtos WHERE id = $produto_id";
    $res_prod = mysqli_query($conn, $sql_prod);
    $produto = mysqli_fetch_assoc($res_prod);

    $preco = $produto['preco'];
    $subtotal = $preco * $quantidade;
    $total += $subtotal;

    $itens[] = [
        'produto_id' => $produto_id,
        'quantidade' => $quantidade,
        'preco' => $preco,
        'subtotal' => $subtotal
    ];
}

// Cria o pedido
$sql_pedido = "INSERT INTO pedidos (id_usuario, total) VALUES ($id_usuario, $total)";
if (!mysqli_query($conn, $sql_pedido)) {
    die("Erro ao criar pedido: " . mysqli_error($conn));
}

$id_pedido = mysqli_insert_id($conn);

// Insere os itens do pedido
foreach ($itens as $item) {
    $pid = $item['produto_id'];
    $qtd = $item['quantidade'];
    $preco = $item['preco'];
    $subtotal = $item['subtotal'];

    $sql_item = "INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco, subtotal) 
                 VALUES ($id_pedido, $pid, $qtd, $preco, $subtotal)";
    mysqli_query($conn, $sql_item);
}

// Insere o pagamento como pendente
$metodo_pagamento = mysqli_real_escape_string($conn, $_POST['forma_pagamento'] ?? 'cartao');
$sql_pagamento = "INSERT INTO pagamentos (id_pedido, metodo_pagamento) VALUES ($id_pedido, '$metodo_pagamento')";
mysqli_query($conn, $sql_pagamento);

// Limpa o carrinho
mysqli_query($conn, "DELETE FROM itens_carrinho WHERE carrinho_id = $id_carrinho");


// Redireciona para página de confirmação
header("Location: pedido_confirmado.php?pedido=$id_pedido");
exit;
?>
