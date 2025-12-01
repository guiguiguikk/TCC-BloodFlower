<?php
session_start();
if(!isset($_SESSION['id']) && $_SESSION['tipo'] != "admin"){
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");
$id = $_GET['id_endereco']; 

$sql = "DELETE FROM enderecos WHERE id_endereco = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: inicioADM?secao=enderecos");
}else{
    die(mysqli_error($conn));
}