<?php
session_start();
include("conexao.php");
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
$id_usuario = $_SESSION["id"];
$id_endereco = $_GET["id"];

$sql = "DELETE FROM enderecos WHERE id_endereco = $id_endereco";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['mensagem_endereco'] = [
        'tipo' => 'success',
        'texto' => 'Endereço excluído com sucesso!'
    ];
} else {
    $_SESSION['mensagem_endereco'] = [
        'tipo' => 'danger',
        'texto' => 'Erro ao excluir o endereço.'
    ];
}

header("Location: perfil.php?secao=endereco");
exit;