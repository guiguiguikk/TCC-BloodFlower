<?php
session_start();
if(!isset($_SESSION['id']) && $_SESSION['tipo'] != "admin"){
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");

$id = $_GET['id_usuario'];

$sql = "DELETE FROM usuarios WHERE id_usuario = $id";
$result = mysqli_query($conn, $sql);

if($result){
    header("Location: inicioADM.php?secao=usuarios");
    exit;
}else{
    die(mysqli_error($conn));   
}