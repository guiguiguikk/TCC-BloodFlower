<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}


include("../conexao.php");
$id = $_GET["id_pedido"];

if (isset($id)) {
    $sql_itens_pedido = "DELETE FROM `itens_pedido` WHERE id_pedido = $id";
    $query = mysqli_query($conn, $sql_itens_pedido);
    if ($sql_itens_pedido) {

        $sql = "DELETE FROM `pedidos` WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION["mensagem"] = [
                "text" => "Pedido excluído com sucesso",
                "tipo" => "success"
            ];


            header("Location: inicioADM.php?secao=pedidos");
        } else {
            $_SESSION["mensagem"] = [
                "text" => "Erro ao excluir pedido",
                "tipo" => "danger"
            ];
            header("Location: inicioADM.php?secao=pedidos");
        }
    } else {

        $_SESSION["mensagem"] = [
            "text" => "Erro ao excluir itens do pedido",
            "tipo" => "danger"
        ];
        header("Location: inicioADM.php?secao=pedidos");
    }
}
