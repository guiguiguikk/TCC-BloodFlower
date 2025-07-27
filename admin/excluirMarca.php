<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");
$id_marca = $_GET['id_marca'];
$sql = "DELETE FROM marcas WHERE id_marca = $id_marca";
if (mysqli_query($conn, $sql)) {
    echo "Marca excluída com sucesso.";
} else {
    echo "Erro ao excluir marca: " . mysqli_error($conn);
}
mysqli_close($conn);
?>