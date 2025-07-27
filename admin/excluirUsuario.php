<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

    $id_usuario = $_GET['id'];


    $sql = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
    $result = mysqli_query($conn, $sql);

  
    header("Location: usuarios.php");
    exit;

?>