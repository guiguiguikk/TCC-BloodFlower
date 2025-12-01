<?php
session_start();
if(!isset($_SESSION['id']) && $_SESSION['tipo'] != "admin"){
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
$id = $_GET['id_produto'];
$sql = "DELETE FROM produtos WHERE id_produto = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: inicioADM.php?secao=produtos");
    exit;
}else{
    die(mysqli_error($conn));
}