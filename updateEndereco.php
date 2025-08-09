<?php
session_start();
include("conexao.php");
if (!isset($_SESSION['id']) || $_SESSION["tipo"] != "cliente") {
    header("Location: entrar.php");
    exit;
}
$id_usuario = $_SESSION["id"];
$id_endereco = mysqli_real_escape_string($conn, $_POST['id_endereco']);
$cep = mysqli_real_escape_string($conn, $_POST['cep']);
$rua = mysqli_real_escape_string($conn, $_POST['rua']);
$numero = mysqli_real_escape_string($conn, $_POST['numero']);
$bairro = mysqli_real_escape_string($conn, $_POST['bairro']);
$cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
$estado = mysqli_real_escape_string($conn, $_POST['estado']);

$sql = "UPDATE enderecos SET cep = '$cep', rua = '$rua', numero = '$numero', bairro = '$bairro', cidade = '$cidade', estado = '$estado' WHERE id_endereco = $id_endereco AND usuario_id = $id_usuario";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['mensagem_endereco'] = [
        'tipo' => 'success',
        'texto' => 'Endereço atualizado com sucesso!'
    ];
} else {
    $_SESSION['mensagem_endereco'] = [
        'tipo' => 'danger',
        'texto' => 'Erro ao atualizar o endereço: ' . mysqli_error($conn)
    ];
}

header("Location: perfil.php?secao=endereco");