<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$id_endereco = $_GET['id'];
$sql = "DELETE FROM enderecos WHERE id_endereco = $id_endereco";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: enderecos.php?msg=Endereço excluído com sucesso.");
} else {
    header("Location: enderecos.php?msg=Erro ao excluir endereço.");
}