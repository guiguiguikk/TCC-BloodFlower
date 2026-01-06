<?php
session_start();
if(!isset($_SESSION['id']) && $_SESSION['tipo'] != "admin"){
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");

$id = $_GET['id_tamanho'];

$sql = "DELETE FROM tamanhos WHERE id_tamanho = $id";
$result = mysqli_query($conn, $sql);

if($result){
    header("Location: inicioADM.php?secao=tamanhos");
    exit;
}else{
    die(mysqli_error($conn));
}