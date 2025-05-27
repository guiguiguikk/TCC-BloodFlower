<?php
include("../conexao.php"); 

$id = $_GET['id'];

$sql = "DELETE FROM produtos WHERE id = $id";  
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: inicioADM.php");
    exit();
} else {
    echo "Erro ao excluir produto: " . mysqli_error($conn);
    echo "<a href='inicioADM.php'><button>Voltar</button></a>";
}
