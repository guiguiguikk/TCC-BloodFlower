<?php
session_start();
if(!isset($_SESSION['id']) && $_SESSION['tipo'] != "admin"){
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
$id = $_GET['id'];
$sql = "DELETE FROM produtos WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: inicioADM.php?secao=produto");
    exit;
}else{
    die(mysqli_error($conn));
}