<?php
session_start();
if(!isset($_SESSION['id']) && $_SESSION['tipo'] != "admin"){
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");

$id = $_GET['id_marca'];

$sql = "DELETE FROM marca WHERE id_marca = $id";
$result = mysqli_query($conn, $sql);

if($result){
    header("Location: inicioADM.php?secao=marcas");
    exit;
}else{
    die(mysqli_error($conn));
}