<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'cliente') {
    header("Location: entrar.php");
    exit;
}

include("conexao.php");


    // Captura o ID do cliente
    $cliente_id = $_SESSION['id'];

    // Limpa e trata os dados
    $cep = str_replace("-", "", trim($_POST['cep']));
    $rua = trim($_POST['rua']);
    $numero = trim($_POST['numero']);
    $bairro = trim($_POST['bairro']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);

    // Verifica se todos os campos foram preenchidos
    if (empty($cep) || empty($rua) || empty($numero) || empty($bairro) || empty($cidade) || empty($estado)) {
        echo "Todos os campos são obrigatórios!";
        exit;
    }

    // Escapa os dados para segurança
    $cep = mysqli_real_escape_string($conn, $cep);
    $rua = mysqli_real_escape_string($conn, $rua);
    $numero = mysqli_real_escape_string($conn, $numero);
    $bairro = mysqli_real_escape_string($conn, $bairro);
    $cidade = mysqli_real_escape_string($conn, $cidade);
    $estado = mysqli_real_escape_string($conn, $estado);

    // Insere os dados
    $sql = "INSERT INTO enderecos (usuario_id, cep, rua, numero, bairro, cidade, estado)
            VALUES ('$cliente_id', '$cep', '$rua', '$numero', '$bairro', '$cidade', '$estado')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensagem_endereco'] = [
            'tipo' => 'success',
            'texto' => 'Endereço cadastrado com sucesso!'
        ];
    } else {
        $_SESSION['mensagem_endereco'] = [
            'tipo' => 'danger',
            'texto' => 'Erro ao cadastrar endereço: ' . mysqli_error($conn)
        ];
    }


    header("Location: perfil.php?secao=endereco");
    exit;

