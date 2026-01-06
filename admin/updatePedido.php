<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: entrar.php");
    exit;
}
include("../conexao.php");

$id_pedido = $_POST['id_pedido'] ?? 0;
$status = $_POST['status'] ?? '';

$sql = "UPDATE pedidos SET status = '$status' WHERE id = $id_pedido";
if (mysqli_query($conn, $sql)) {
    $_SESSION['mensagem'] = [
        'tipo' => 'success',
        'text' => 'Pedido atualizado com sucesso!'
    ];
} else {
    $_SESSION['mensagem'] = [
        'tipo' => 'danger',
        'text' => 'Erro ao atualizar o pedido: ' . mysqli_error($conn)
    ];
}

header("Location: inicioADM.php?secao=pedidos");