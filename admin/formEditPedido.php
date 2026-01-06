<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: entrar.php");
    exit;
}
include("../conexao.php");

$id_pedido = isset($_GET['id_pedido']) ? (int) $_GET['id_pedido'] : 0;

$sql = "SELECT * FROM pedidos WHERE id = $id_pedido";
$result = mysqli_query($conn, $sql);
$pedido = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Marca - BloodFlower</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(145deg, #f5f5f5, #e9ecef);
            font-family: 'Rubik', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .marca-box {
            background: #fff;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.07);
            width: 100%;
            max-width: 600px;
        }

        .produto-box h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #8b0000;
            text-align: center;
            margin-bottom: 8px;
        }

        .produto-box p.subtitle {
            text-align: center;
            font-size: 1rem;
            color: #666;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            height: 45px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
        }

        .btn-submit {
            background-color: #8b0000;
            color: white;
            border-radius: 12px;
            height: 45px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #a40000;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="marca-box">
        <h1>BloodFlower</h1>
        <p class="subtitle">Cadastro de Nova Marca</p>

        <!-- Mensagem de erro -->
        <?php if (isset($_SESSION['erro_produto'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $_SESSION['erro_produto'] ?>
            </div>
            <?php unset($_SESSION['erro_produto']); ?>
        <?php endif; ?>

        <form action="updatePedido.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" name="id_pedido" value="<?php echo $pedido['id']; ?>">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pendente" <?php if ($pedido['status'] == 'pendente') echo 'selected'; ?>>Pendente</option>
                    <option value="processando" <?php if ($pedido['status'] == 'processando') echo 'selected'; ?>>Processando</option>
                    <option value="enviado" <?php if ($pedido['status'] == 'enviado') echo 'selected'; ?>>Enviado</option>
                    <option value="entregue" <?php if ($pedido['status'] == 'entregue') echo 'selected'; ?>>Entregue</option>
                </select>
            </div>
            
            <button type="submit" class="btn-submit">Cadastrar Marca</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
