<?php
session_start();
if(!isset($_SESSION['id']) && $_SESSION['tipo'] != "admin"){
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$id = $_GET['id_categoria'];

$sql = "DELETE FROM categorias WHERE id_categoria = $id";
$result = mysqli_query($conn, $sql);

if($result){
    header("Location: inicioADM.php?secao=categorias");
    exit;
}else{
    die(mysqli_error($conn));
}