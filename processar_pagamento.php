<?php
session_start();
include("conexao.php");

// Verifica se o usuário está logado e é cliente
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}

$id_usuario = $_SESSION["id"];

// 1. BUSCAR DADOS DO CLIENTE (Necessário para o boleto)
$sql_user_info = "SELECT u.nome, u.cpf, u.email, e.cep, e.cidade, e.estado, e.rua
 FROM usuarios u JOIN enderecos e ON u.id_usuario = e.usuario_id WHERE u.id_usuario = $id_usuario";
$res_user = mysqli_query($conn, $sql_user_info);
$cliente_dados = mysqli_fetch_assoc($res_user);

// Verifica se achou o cliente
$nome_cliente = $cliente_dados['nome'] ?? 'Cliente Desconhecido';
$cpf_cliente  = $cliente_dados['cpf'] ?? '000.000.000-00';
$end_cliente  = $cliente_dados['rua'] . " - " . $cliente_dados['cidade'] . "/" . $cliente_dados['estado'];

// --- PROCESSO DO CARRINHO (Seu código original) ---
$sql_carrinho = "SELECT * FROM carrinhos WHERE usuario_id = $id_usuario";
$result_carrinho = mysqli_query($conn, $sql_carrinho);

if (!$result_carrinho || mysqli_num_rows($result_carrinho) == 0) {
    die("Carrinho não encontrado.");
}

$carrinho = mysqli_fetch_assoc($result_carrinho);
$id_carrinho = $carrinho['id_carrinho'];

$sql_itens = "SELECT * FROM itens_carrinho WHERE carrinho_id = $id_carrinho";
$result_itens = mysqli_query($conn, $sql_itens);

if (!$result_itens || mysqli_num_rows($result_itens) == 0) {
    die("Seu carrinho está vazio.");
}

$total = 0;
$itens = [];

while ($item = mysqli_fetch_assoc($result_itens)) {
    $produto_id = $item['produto_id'];
    $quantidade = $item['quantidade'];

    $sql_prod = "SELECT nome, preco FROM produtos WHERE id = $produto_id"; // Peguei o NOME também
    $res_prod = mysqli_query($conn, $sql_prod);
    $produto = mysqli_fetch_assoc($res_prod);

    $preco = $produto['preco'];
    $subtotal = $preco * $quantidade;
    $total += $subtotal;

    $itens[] = [
        'nome' => $produto['nome'], // Guardando nome para mostrar no boleto se quiser
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

// Insere os itens
foreach ($itens as $item) {
    $pid = $item['produto_id'];
    $qtd = $item['quantidade'];
    $preco = $item['preco'];
    $subtotal = $item['subtotal'];
    $sql_item = "INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco, subtotal) 
                 VALUES ($id_pedido, $pid, $qtd, $preco, $subtotal)";
    mysqli_query($conn, $sql_item);
}

// Pagamento
$metodo_pagamento = mysqli_real_escape_string($conn, $_POST['metodo_pagamento'] ?? 'pix'); // mudei para POST pois geralmente vem de form
if (isset($_GET['metodo_pagamento'])) $metodo_pagamento = $_GET['metodo_pagamento']; // fallback para GET se necessário

$sql_pagamento = "INSERT INTO pagamentos (id_pedido, metodo_pagamento) VALUES ($id_pedido, '$metodo_pagamento')";
mysqli_query($conn, $sql_pagamento);

// Limpa carrinho
mysqli_query($conn, "DELETE FROM itens_carrinho WHERE carrinho_id = $id_carrinho");



// Se NÃO for boleto (ex: pix, cartão), vai para a página de confirmação
header("Location: pedido_confirmado.php?pedido=$id_pedido");
exit;
