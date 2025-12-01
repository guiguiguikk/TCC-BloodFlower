<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$id_categoria = $_POST['id_categoria'];
$nome = $_POST['nome'];

$sql = "UPDATE categorias SET nome = '$nome' WHERE id_categoria = $id_categoria";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=categorias");
} else {
    header("Location: formEditCategoria.php?id_categoria=$id_categoria");
}
?>