<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

$id_marca = $_POST['id_marca'];
$nome = $_POST['nome'];

$sql = "UPDATE marca SET nome = '$nome' WHERE id_marca = $id_marca";
if (mysqli_query($conn, $sql)) {
    header("Location: inicioADM.php?secao=marcas");
} else {
    header("Location: formEditMarca.php?id_marca=$id_marca");
}