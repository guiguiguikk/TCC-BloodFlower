<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}
include("../conexao.php");

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    $sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
    $result = mysqli_query($conn, $sql);
    $usuario = mysqli_fetch_assoc($result);

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodFlower | Editar Usuário</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            padding: 40px 20px;
        }

        .container-usuario {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .title {
            text-align: center;
            color: #dc3545;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .btn-submit {
            background-color: #dc3545;
            color: white;
            font-weight: 500;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            transition: 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #b02a37;
        }
    </style>
</head>

<body>
    <div class="container-usuario">
        <form action="editarUsuario.php" method="POST">
            <h1 class="title">Edição de Usuário</h1>
            <p class="subtitle">Atualize as informações do usuário</p>

            <input type="hidden" name="id" value="<?php echo $usuario['id_usuario']; ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $usuario['cpf']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $usuario['telefone']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>" required>
            </div>


            <button type="submit" class="btn btn-submit">Atualizar Usuário</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
    var_dump($usuario);
    die();

?>

</html>